<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\ProductFilter;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminProductController extends ApiController
{
    public function __construct(protected ProductService $productService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageProduct->getSection();
        $this->resource = ProductResource::class;
        $this->service = $productService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/products',
        description: 'Get all products',
        summary: 'List products',
        security: [['Bearer' => []]],
        tags: ['Admin Product']
    )]
    #[OA\Parameter(ref: "#/components/parameters/direction")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'search',
        description: 'Apply filter by product name.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
    name: 'haveMaxStars',
    in: 'query',
    description: 'Sort products by field',
    required: false,
    schema: new OA\Schema(type: 'string', enum: ['1']))]
    #[OA\Parameter(
        name: 'publish',
        description: 'Apply filter by publish status.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'boolean')
    )]
    #[OA\Parameter(
        name: 'type',
        description: 'Apply filter by type .',
        in: 'query',
        required: false,
        schema: new OA\Schema(
        type: 'string',
        enum: ['GRANOLA', 'GRANOLA_BARS', 'PENNUT_BUTTER'])
    )]
    #[OA\Parameter(
        name: 'categoryId',
        description: 'Apply filter by product category.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'brandId',
        description: 'Apply filter by product brand.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer')
    )]

    #[OA\Parameter(
        name: 'inStock',
        description: 'Apply filter by product stock status.',
        in: 'query',
        required: false,
        schema: new OA\Schema(
        type: 'string',
        enum: ['1', '0'])
        )]
    #[OA\Parameter(
        name: 'expired',
        description: 'Apply filter by product expiry status.',
        in: 'query',
        required: false,
        schema: new OA\Schema(
        type: 'string',
        enum: ['1', '0'])
        )]
    #[OA\Parameter(
        name:"priceMin",
        in:"query",
        required:false,
        description:"Minimum price filter",
        schema: new OA\Schema(type: 'number')
        )]
    #[OA\Parameter(
        name:"priceMax",
        in:"query",
        required:false,
        description:"Maximum price filter",
        schema: new OA\Schema(type: 'number')
        )]
    #[OA\Parameter(
        name:"haveReviews",
        in:"query",
        required:false,
        description:"product have review or not",
        schema: new OA\Schema(
        type: 'string',
        enum: ['1', '0'])
        )]

    #[OA\Response(
        response: 200,
        description: 'Returns all products',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/Product')
                    ),
                ]
            )
        )
    )]
    public function index(ProductFilter $productFilter): JsonResponse
    {

        return parent::baseIndex($productFilter);
    }

    #[OA\Post(
        path: '/api/admin/products',
        description: 'Create a new product',
        summary: 'Create product',
        security: [['Bearer' => []]],
        tags: ['Admin Product']
    )]
   #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Toyota Engine'),
                    new OA\Property(property: 'description', type: 'string', example: 'Genuine engine part'),
                    new OA\Property(property: 'categoryId', type: 'integer', example: 3),
                    new OA\Property(property: 'brandId', type: 'integer', example: 3),
                    new OA\Property(property: 'type', type: 'string', enum: ['GRANOLA', 'GRANOLA_BARS', 'PENNUT_BUTTER']),
                    new OA\Property(property: 'price', type: 'number', format: 'float', example: 2500.00),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),
                    new OA\Property(property: 'stock', type: 'number', example: 4),
                    new OA\Property(property: 'ingredients', type: 'array', items: new OA\Items(type: 'integer'), example: [1]),
                    new OA\Property(property: 'productionDate', type: 'date', example: '2024-07-15 15:22:32'),
                    new OA\Property(property: 'expirationDate', type: 'date', example: '2024-07-15 15:22:32'),

                    new OA\Property(property: 'image', type: 'file'),
                ],
            required: ['name', 'price', 'categoryId'],
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created product',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Product')
        )
    )]
    public function store(ProductRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    #[OA\Get(
        path: '/api/admin/products/{product}',
        description: 'Get product details by ID',
        summary: 'Get product details',
        security: [['Bearer' => []]],
        tags: ['Admin Product']
    )]
    #[OA\Parameter(
        name: 'product',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Product ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns product details',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Product')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Product not found'
    )]
    public function show(Product $product): JsonResponse
    {
        return parent::baseShow($product);
    }

    #[OA\Post(
        path: '/api/admin/products/{product}',
        description: 'Update product by ID',
        summary: 'Update product',
        security: [['Bearer' => []]],
        tags: ['Admin Product']
    )]
    #[OA\Parameter(
        name: 'product',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Product ID'
    )]
      #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: '_method', type: 'text', example: 'PUT'),
                    new OA\Property(property: 'name', type: 'string', example: 'Toyota Engine'),
                    new OA\Property(property: 'description', type: 'string', example: 'Genuine engine part'),
                    new OA\Property(property: 'categoryId', type: 'integer', example: 3),
                    new OA\Property(property: 'brandId', type: 'integer', example: 3),
                    new OA\Property(property: 'type', type: 'string', enum: ['GRANOLA', 'GRANOLA_BARS', 'PENNUT_BUTTER']),
                    new OA\Property(property: 'price', type: 'number', format: 'float', example: 2500.00),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),
                    new OA\Property(property: 'ingredients', type: 'array', items: new OA\Items(type: 'integer'), example: [1]),
                    new OA\Property(property: 'image', type: 'file'),
                ],
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns Updated Product',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', example: true),
                    new OA\Property(property: 'data', ref: '#/components/schemas/Product', type: 'object'),
                ]
            )
        )
    )]
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        return parent::baseUpdate($request, $product);
    }

    #[OA\Delete(
        path: '/api/admin/products/{product}',
        description: 'Delete product by ID',
        summary: 'Delete product',
        security: [['Bearer' => []]],
        tags: ['Admin Product']
    )]
    #[OA\Parameter(
        name: 'product',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Product ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns deleted product'
    )]
    #[OA\Response(
        response: 404,
        description: 'Product not found'
    )]
    public function destroy(Product $product): JsonResponse
    {
        return parent::baseDestroy($product);
    }
}
