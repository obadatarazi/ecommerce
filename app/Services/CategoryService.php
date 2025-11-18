<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends BaseService
{

    public function __construct()
{
    $this->model = Category::class;
    parent::__construct();
}
    /**
     * new category
     */
    public function create($data): Category
    {
        $category = new Category($data);
        $category->fill($data);
        $category->save();

        return $category;
    }

    /**
    * update exist category
     */
    public function update($data, Category|Model $category): Category
    {
        $category->update($data);
        $category->fill($data);
        return $category;
    }

    /**
     * update publish status
     * */
    public function togglePublish(Category|Model $category, bool $status): Category
    {
        $category->publish = $status;
        $category->save();

        return $category;
    }

}
