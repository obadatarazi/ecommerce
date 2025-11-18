<?php

namespace App\Http\Resources;

use App\Constant\SerializedGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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

        return [
            'id' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->id),
            'name' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->name),
            'description' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->description),
            'publish' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->publish),
            'createdAt' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->created_at),
            'updatedAt' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->updated_at),
            'deleteAt' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->delete_at)

        ];
    }
}
