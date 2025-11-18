<?php

namespace App\Http\Resources;

use App\Constant\SerializedGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $serializedGroup = $request->get('serializedGroup');

        $permissionArr = [];
        foreach($this->permissions as $permission) {
            $permissionArr[] = $permission->name;
        }

        return [
            'id' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->id),
            'name' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->name),
            'code' => $this->when($serializedGroup === SerializedGroup::Details->value, $this->code),
            'standard' => $this->when($serializedGroup === SerializedGroup::Details->value, $this->standard),
            'permissions' => $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $permissionArr),
            'createdAt' => $this->when(
                $serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value, $this->created_at),
            'updatedAt' => $this->when(
                $serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value, $this->updated_at)
        ];
    }
};
