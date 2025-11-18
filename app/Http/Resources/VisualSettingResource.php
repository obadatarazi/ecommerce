<?php

namespace App\Http\Resources;

use App\Constant\SerializedGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisualSettingResource extends JsonResource
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
            'settingKey' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->setting_key),
            'imageFileUrl' => $this->when(
                $serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value, $this->image_file_url),
            'link' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->link),
            'title' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->title),
            'description' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->description),
            'translations' => $this->when($serializedGroup === SerializedGroup::Details->value, $this->customTranslations),
            'createdAt' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->created_at),
            'updatedAt' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->updated_at)
        ];
    }
}
