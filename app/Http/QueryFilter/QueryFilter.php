<?php

namespace App\Http\QueryFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer;

class QueryFilter
{
    protected $request;

    protected $query;

    protected array $validationArray = [];

    protected $searchColumns = [];

    /**
     * QueryFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        foreach ($this->validationArray as $key => $value) {
            if ($request->has($key) && $value === 'boolean') {
                $publishValue = filter_var($request->input($key), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                $request->merge([$key => $publishValue]);
            }
        }

        if ($this->validationArray) {
            Validator::validate($request->all(), array_merge($this->validationArray, ['sorts' => 'array']));
        }

    }

    /**
     * @param Builder $query
     * @param array $filterable
     * @return mixed
     */
    public function applyFilter(Builder $query, $filterable = []): mixed
    {
        $this->query = $query;

        foreach ($this->getFiltersFields() as $name => $value) {
            $snakeName = Str::snake($name);

            if (method_exists($this, $name) && $value !== '') {
                call_user_func_array([$this, $name], [$value]);
            } elseif (isset($filterable[$snakeName])) {
                $this->query->where($snakeName, $filterable[$snakeName], $value);
            }
        }
        return $this->query;
    }

    public function applySort(Builder $query, $sorterable = []): mixed
    {
        $this->query = $query;

        $sort = $this->getSortField();
        $direction = $this->getSortDirection();

        if (!empty($sort)) {
            if (in_array($sort, $sorterable)) {
                $this->query->orderBy($sort, $direction);
            }
        }

        return $this->query;
    }

    public function getFiltersFields(): array
    {
        return $this->request->all();
    }

    public function getSortField()
    {
        return $this->request->get('sort', '');
    }

    public function setFilter($filter, $value)
    {
        return $this->request[$filter] = $value;
    }

    public function getSortDirection()
    {
        return $this->request->get('direction', 'asc');
    }

    public function search($search)
    {
        $model = $this->query->getModel();
        $hasTranslatedAttributes = is_array($model->translatedAttributes) && !empty($model->translatedAttributes);

        if (!empty($this->searchColumns) && $search) {
            $tokens = $this->convertToSeparatedTokens($search);
            $columnsName = implode(',', $this->searchColumns);

            if ($hasTranslatedAttributes && array_intersect($this->searchColumns, $model->translatedAttributes)) {

                return $this->query->whereHas('translations', function ($q) use ($columnsName, $tokens) {
                    $q->whereRaw("MATCH($columnsName) AGAINST(? IN BOOLEAN MODE)", $tokens);
                });

            } else {
                return $this->query->whereRaw("MATCH($columnsName) AGAINST(? IN BOOLEAN MODE)", $tokens);
            }
        }

        return $this->query;
    }

    function stripPunctuation($string): string
    {
        $string = strtolower($string);
        $string = preg_replace('/[[:punct:]]/', " ", $string);
        return trim($string);
    }

    function convertToSeparatedTokens($string): string
    {
        $string = $this->stripPunctuation($string);
        $tokenizer = new WhitespaceAndPunctuationTokenizer();
        $tokens = $tokenizer->tokenize($string);
        array_walk($tokens, function (&$value) {
            if ($value) {
                $value = $value . '*';
            }
        });
        return implode(' ', $tokens);
    }
}
