<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;

class BrandService extends BaseService
{

    public function __construct()
{
    $this->model = Brand::class;
    parent::__construct();
}
    /**
     * new Brand
     */
    public function create($data): Brand
    {
        $brand = new Brand($data);
        $brand->fill($data);
        $brand->save();

        return $brand;
    }

    /**
    * update exist rand
     */
    public function update($data, Brand|Model $brand): Brand
    {
        $brand->update($data);
        $brand->fill($data);
        return $brand;
    }

    /**
     * update publish status
     * */
    public function togglePublish(Brand|Model $brand, bool $status): Brand
    {
        $brand->publish = $status;
        $brand->save();

        return $brand;
    }
 /**
     * update featured status
     * */
    public function toggleFeatured(Brand|Model $brand, bool $status): Brand
    {
        $brand->featured = $status;
        $brand->save();

        return $brand;
    }

}
