<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserGender;
use Illuminate\Support\Facades\App;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

class OptionController extends ApiController
{
    /**
     * Get Gender Type.
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/api/options/users/gender',
        description: 'get enum value user gender',
        summary: 'Get Enum Value User Gender',
        tags: ['Options'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns User Gender Options',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean"),
                        new OA\Property(property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property('label', type: 'string', example: 'Male'),
                                    new OA\Property('value', type: 'string', example: 'MALE'),
                                ]
                            )
                        ),
                    ]
                )
            ),
        ]
    )]
    public function getGenderType(): JsonResponse
    {
        $locale = App::getLocale();

        $data = UserGender::getOptions($locale);

        return $this->successResponse($data);
    }
}
