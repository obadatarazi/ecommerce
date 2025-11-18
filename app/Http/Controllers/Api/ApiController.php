<?php

namespace App\Http\Controllers\Api;

use App\Constant\SerializedGroup;
use App\Http\QueryFilter\QueryFilter;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Laravel Core App Rest"
)]
#[OA\SecurityScheme(
    securityScheme: "Bearer",
    type: "http",
    name: "Bearer",
    in: "header",
    bearerFormat: "JWT",
    scheme: "Bearer"
)]
class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ApiResponser;

    protected $permissionPrefix;
    protected $service;
    protected $resource;
    public function __construct()
    {
        $this->appendGeneralPermissions();
    }

    public function appendGeneralPermissions(): void
    {
        $this->middleware(["permission:MANAGE_$this->permissionPrefix|PERMISSION_SHOW_$this->permissionPrefix|PERMISSION_UPDATE_$this->permissionPrefix|PERMISSION_DELETE_$this->permissionPrefix"], ['only' => ['index', 'show']]);
        $this->middleware(["permission:MANAGE_$this->permissionPrefix|PERMISSION_CREATE_$this->permissionPrefix"], ['only' => ['store']]);
        $this->middleware(["permission:MANAGE_$this->permissionPrefix|PERMISSION_UPDATE_$this->permissionPrefix"], ['only' => ['update']]);
        $this->middleware(["permission:MANAGE_$this->permissionPrefix|PERMISSION_DELETE_$this->permissionPrefix"], ['only' => ['destroy']]);
    }

    public function baseIndex(QueryFilter $queryFilter, $isOnlyPublished = false): JsonResponse
    {
        $items = $isOnlyPublished ? $this->service->findAllPublished($queryFilter)
            :  $this->service->findAllPaginated($queryFilter);

        return $this
            ->setResourceClass($this->resource)
            ->setSerializedGroup(SerializedGroup::List->value)
            ->successPaginatedResponse($this->resource, $items);
    }

    public function baseStore(Request $request): JsonResponse
    {
        $object = $this->service->create($request->validated());

        return $this
            ->setResourceClass($this->resource)
            ->setSerializedGroup(SerializedGroup::Details->value)
            ->successResponse($object, 201);
    }

    public function baseShow(Model $object): JsonResponse
    {
        return $this
            ->setResourceClass($this->resource)
            ->setSerializedGroup(SerializedGroup::Details->value)
            ->successResponse($object);
    }

    public function baseUpdate(Request $request, Model $object): JsonResponse
    {
        $object = $this->service->update($request->validated(), $object);

        return $this
            ->setResourceClass($this->resource)
            ->setSerializedGroup(SerializedGroup::Details->value)
            ->successResponse($object);
    }

    public function baseDestroy(Model $object): JsonResponse
    {
        $this->service->delete($object);

        return $this
            ->setResourceClass($this->resource)
            ->setSerializedGroup(SerializedGroup::Details->value)
            ->successResponse($object);
    }
}
