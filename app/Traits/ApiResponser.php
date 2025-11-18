<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    protected $resourceClass;

    public function successPaginatedResponse($resourceClass, $data): JsonResponse
    {
        $items = $resourceClass::collection($data);

        $res = [
            'success' => true,
            'statusCode' => 200,
            'pagination' => [
                'page' => $data->currentPage(),
                'limit' => $data->perPage(),
                'pages' => ceil($data->total() / $data->perPage()),
                'totalItems' => $data->total(),
                'items' => $items,
            ],
        ];

        return response()->json($res, 200);
    }

    /**
     * success response method.
     *
     * @param $data
     * @param int $code
     * @param null $message
     * @return JsonResponse
     */
    protected function successResponse($data, int $code = 200, $message = null): JsonResponse
    {
        if($this->resourceClass)
            $data = new $this->resourceClass($data);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * error response method.
     *
     * @param null $error
     * @param int $code
     * @return JsonResponse
     */
    protected function errorResponse($error = null, $code = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => $error,
        ], $code);
    }

    public function successCustomResponse($resourceClass, $data): JsonResponse
    {
        $res = $resourceClass::collection($data);

        return response()->json($res, 200);
    }

    public function setSerializedGroup($group): self
    {
        request()['serializedGroup'] = $group;

        return $this;
    }

    public function setResourceClass($resourceClass): self
    {
        $this->resourceClass = $resourceClass;

        return $this;
    }
}
