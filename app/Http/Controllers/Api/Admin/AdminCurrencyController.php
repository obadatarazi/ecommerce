<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\CurrencyFilter;
use App\Http\Requests\Admin\CurrencyRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminCurrencyController extends ApiController
{
    public function __construct(protected CurrencyService $currencyService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageCurrency->getSection();
        $this->resource = CurrencyResource::class;
        $this->service = $currencyService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/currencies',
        description: 'Get all Currencies',
        summary: 'List Currencies',
        security: [['Bearer' => []]],
        tags: ['Admin Currency'],
       )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(ref: "#/components/parameters/direction")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'search',
        description: 'Apply filter by currency name.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'publish',
        description: 'Apply filter by publish status.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'boolean')
    )]

    #[OA\Parameter(
        name: 'symbol',
        description: 'Apply filter by symbol.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string')
    )]

    #[OA\Response(
        response: 200,
        description: 'Returns all currencies',
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/Currency')
                    ),
                ]
            )
        )
    )]
    public function index(CurrencyFilter $currencyFilter): JsonResponse
    {
        return parent::baseIndex($currencyFilter);
    }

    #[OA\Post(
        path: '/api/admin/currencies',
        description: 'Create a new currency',
        summary: 'Create currency',
        security: [['Bearer' => []]],
        tags: ['Admin Currency'],

    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Syrian Arab Republic'),
                    new OA\Property(property: 'symbol', type: 'string', example: 'SYP'),
                    new OA\Property(property: 'iso', type: 'string', example: 'SYP'),
                    new OA\Property(property: 'exhange_rate', type: 'number', format: 'float', example: 11900.0),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created currency',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Currency')
        )
    )]
    public function store(CurrencyRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    #[OA\Get(
        path: '/api/admin/currencies/{currency}',
        description: 'Get one currency by ID',
        summary: 'Get currency details',
        security: [['Bearer' => []]],
        tags: ['Admin Currency'],

    )]
    #[OA\Parameter(
        name: 'currency',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Currency ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns currency details',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Currency')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Currency not found'
    )]
    public function show(Currency $currency): JsonResponse
    {
        return parent::baseShow($currency);
    }

    #[OA\Put(
        path: '/api/admin/currencies/{currency}',
        description: 'Update currency by ID',
        summary: 'Update currency',
        security: [['Bearer' => []]],
        tags: ['Admin Currency'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],

    )]
    #[OA\Parameter(
        name: 'currency',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Currency ID'
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'update Syrian Arab Republic'),
                    new OA\Property(property: 'symbol', type: 'string', example: 'NSYP'),
                    new OA\Property(property: 'iso', type: 'string', example: 'NSYP'),
                    new OA\Property(property: 'exhange_rate', type: 'number', format: 'float', example: 11700.0),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns updated currency',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Currency')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Currency not found'
    )]
    public function update(CurrencyRequest $request, Currency $currency): JsonResponse
    {
        return parent::baseUpdate($request, $currency);
    }

    #[OA\Delete(
        path: '/api/admin/currencies/{currency}',
        description: 'Delete currency by ID',
        summary: 'Delete currency',
        security: [['Bearer' => []]],
        tags: ['Admin Currency']
    )]
    #[OA\Parameter(
        name: 'currency',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Currency ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns deleted currency'
    )]
    #[OA\Response(
        response: 404,
        description: 'Currency not found'
    )]
    public function destroy(Currency $currency): JsonResponse
    {

        return parent::baseDestroy($currency);
    }
}
