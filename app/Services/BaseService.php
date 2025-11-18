<?php
namespace App\Services;

use App\Http\QueryFilter\QueryFilter;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    const UPLOAD_FOLDER = 'others';
    protected $model;
    protected $keyFileMaps = [];
    protected $uploadFileService;
    protected $withRelations = [];

    public function __construct()
    {
    }

    public function findAllPaginated(QueryFilter $modelFilter)
    {
        $page = $modelFilter->getFiltersFields()['page'];
        $limit = $modelFilter->getFiltersFields()['limit'];

        $query = $this->model::query()->with($this->withRelations)->filter($modelFilter);

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    public function findAllPublished(QueryFilter $modelFilter)
    {
        $modelFilter->setFilter('publish', true);

        return $this->findAllPaginated($modelFilter);
    }

    public function create($data)
    {
        $object = new $this->model($data);

        if (!empty($this->keyFileMaps)) {
            $this->uploadFileService->uploadFiles(
                $data,
                $this->keyFileMaps,
                $object,
                $this::UPLOAD_FOLDER
            );
        }

        $object->save();

        return $object;
    }

    public function update($data, Model $object)
    {
        $object->update($data);

        if (!empty($this->keyFileMaps)) {
            $this->uploadFileService->updateFiles(
                $data,
                $this->keyFileMaps,
                $object,
                $this::UPLOAD_FOLDER
            );
        }

        $object->save();

        return $object;
    }

    public function delete(Model $object): void
    {
        if (!empty($this->keyFileMaps)) {
            $paths = [];
            foreach ($this->keyFileMaps as $fileModelKey => $fileRequestKey) {

                if (!is_null($object->$fileModelKey)) {
                    $paths[] = $object->$fileModelKey;
                }

            }
            $this->uploadFileService->removeFiles($paths);

        }

        $object->delete();
    }

    public function getFindByColumn(string $column, mixed $value)
{
    $model = $this->model::where($column, $value)->first();

    if (!$model) {
        throw new \Exception("Record not found", 404);
    }

    return $model;
}

}
