<?php

namespace App\Http\Resources;

use App\Constant\SerializedGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->id),
            'fullName' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->full_name),
            'email' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->email),
            'gender' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->custom_gender),
            'phoneNumber' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->phone_number),
            'avatarFileUrl' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->avatar_file_url),
            'dateOfBirth' =>
                $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                    $this->date_of_birth),
            'createdAt' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->created_at),
            'updatedAt' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->updated_at),
            'roles' => RoleResource::collection($this->when(
                $serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value, $this->roles)),
        ];
    }
}
