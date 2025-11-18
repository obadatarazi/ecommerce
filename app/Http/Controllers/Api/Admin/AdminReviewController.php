<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\ReviewFilter;
use App\Http\Requests\Admin\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminReviewController extends ApiController
{
    public function __construct(protected ReviewService $reviewService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageReview->getSection();
        $this->resource = ReviewResource::class;
        $this->service = $reviewService;
        parent::__construct();
    }


    #[OA\Get(
        path: '/api/admin/reviews',
        description: 'Get all reviews',
        summary: 'List reviews',
        security: [['Bearer' => []]],
        tags: ['Admin Review'],
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'userId',
        description: 'Filter by User ID',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'productId',
        description: 'Filter by Product ID',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'stars',
        description: 'Filter by star rating (0-5)',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'decimal', minimum: 0, maximum: 5)
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns all reviews',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/Review')
                    ),
                ]
            )
        )
    )]
    public function index(ReviewFilter $reviewFilter): JsonResponse
    {
        return parent::baseIndex($reviewFilter);
    }


    #[OA\Post(
        path: '/api/admin/reviews',
        description: 'Create a new review',
        summary: 'Create review',
        security: [['Bearer' => []]],
        tags: ['Admin Review'],
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                required: ['userId','productId'],
                properties: [
                    new OA\Property(property: 'userId', type: 'integer', example: 5),
                    new OA\Property(property: 'productId', type: 'integer', example: 3),
                    new OA\Property(property: 'comment', type: 'string', example: 'Great quality engine part!'),
                    new OA\Property(property: 'stars', type: 'decimal', example: 5),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created review',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Review')
        )
    )]
    public function store(ReviewRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }


    #[OA\Get(
        path: '/api/admin/reviews/{review}',
        description: 'Get one review by ID',
        summary: 'Get review details',
        security: [['Bearer' => []]],
        tags: ['Admin Review'],
    )]
    #[OA\Parameter(
        name: 'review',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Review ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns review details',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Review')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Review not found'
    )]
    public function show(Review $review): JsonResponse
    {
        return parent::baseShow($review);
    }


    #[OA\Put(
        path: '/api/admin/reviews/{review}',
        description: 'Update review by ID',
        summary: 'Update review',
        security: [['Bearer' => []]],
        tags: ['Admin Review'],
    )]
    #[OA\Parameter(
        name: 'review',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Review ID'
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'comment', type: 'string', example: 'Updated comment about product.'),
                    new OA\Property(property: 'stars', type: 'decimal', example: 4),
                    new OA\Property(property: 'publish', type: 'boolean', example: false),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns updated review',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Review')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Review not found'
    )]
    public function update(ReviewRequest $request, Review $review): JsonResponse
    {
        return parent::baseUpdate($request, $review);
    }

    #[OA\Delete(
        path: '/api/admin/reviews/{review}',
        description: 'Delete review by ID',
        summary: 'Delete review',
        security: [['Bearer' => []]],
        tags: ['Admin Review'],
    )]
    #[OA\Parameter(
        name: 'review',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Review ID'
    )]
    #[OA\Response(response: 200, description: 'Review deleted')]
    #[OA\Response(response: 404, description: 'Review not found')]
    public function destroy(Review $review): JsonResponse
    {
        return parent::baseDestroy($review);
    }
}
