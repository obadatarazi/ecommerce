<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\CurrencyFilter;
use App\Http\Resources\CurrencyResource;
use App\Services\CurrencyService;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CurrencyController extends ApiController
{   public function __construct(protected CurrencyService $currencyService)
    {
        $this->resource = CurrencyResource::class;
        $this->service = $currencyService;
    }
    #[OA\Get(
        path: '/api/currencies',
        description: 'Get all Currencies',
        summary: 'List Currencies',
        tags: ['Currency'],
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
                    ),])))]
    public function index(CurrencyFilter $currencyFilter): JsonResponse
    {
         $currencyFilter->setFilter('publish', true);
        return parent::baseIndex($currencyFilter);
    }

#[OA\Get(
        path: '/api/currencies/{currency}',
        description: 'Get one currency by ID',
        summary: 'Get currency details',
        tags: ['Currency'],

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
    public function show( Currency $currency): JsonResponse
    {
        if ($currency->publish == true ){
        return parent::baseShow($currency);
        }
        else{
        $data = [
        "status" => "400",
        "message" => "Bad Request : The currency you search for it's not publish"
                ];
        return response()->json($data);
            }
}
}
