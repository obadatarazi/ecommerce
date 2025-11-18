<?php

namespace App\Services;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Model;

class IngredientService extends BaseService
{

    public function __construct()
{
    $this->model = Ingredient::class;
    parent::__construct();
}
    /**
     * new ingredient
     */
    public function create($data): Ingredient
    {
        $ingredient = new Ingredient($data);
        $ingredient->fill($data);
        $ingredient->save();

        return $ingredient;
    }

    /**
    * update exist ingredient
     */
    public function update($data, Ingredient|Model $ingredient ): Ingredient
    {
        $ingredient->update($data);
        $ingredient->fill($data);
        return $ingredient;
    }

    /**
     * update publish status
     * */
    public function togglePublish(Ingredient|Model $ingredient, bool $status): Ingredient
    {
        $ingredient->publish = $status;
        $ingredient->save();

        return $ingredient;
    }

}
