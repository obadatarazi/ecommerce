<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;


class ProductService extends BaseService
{
    const UPLOAD_FOLDER = 'products';

public function __construct(UploadFileService $uploadFileService)
{
    $this->uploadFileService = $uploadFileService;
    $this->model = Product::class;
    parent::__construct();
}


    /**
     * Create a new product.
     *
     * @throws \Exception
     */
    public function create($data): Product
    {
        $product = new Product($data);

        // handle any file uploads (e.g. product images)
        $keyFileMaps = [
            'image_file_url' => 'image',
        ];

        $this->uploadFileService->uploadFiles(
            $data,
            $keyFileMaps,
            $product,
            self::UPLOAD_FOLDER
        );

        $product->fill($data);

        $product->save();

        if (isset($data['ingredient'])) {
            $product->ingredients()->sync($data['ingredients']);
            }
        return $product;
    }

    /**
     * Update an existing product.
     *
     *
     * @throws \Exception
     */
    public function update($data, Product|Model $product): Product
    {
        $product->update($data);

        $keyFileMaps = [
            'image_file_url' => 'image',
        ];

        $this->uploadFileService->updateFiles(
            $data,
            $keyFileMaps,
            $product,
            self::UPLOAD_FOLDER
        );

        $product->fill($data);

        if (isset($data['ingredients'])) {
            $product->ingredients()->sync($data['ingredients']);
        }
        $product->save();

        return $product;
    }


    public function getFindById($id):Product
    {
        return Product::query()->find($id);
    }

    /**
     * Toggle product publish status.
     *
     * @param Product|Model $product
     * @param bool $status
     * @return Product
     */
    public function togglePublish(Product|Model $product, bool $status): Product
    {
        $product->publish = $status;
        $product->save();

        return $product;
    }
}


