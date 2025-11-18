<?php

namespace App\Http\Resources;

use App\Constant\SerializedGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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

        $ingredientData = [];

        foreach ($this->ingredients as $ingredient) {
            $ingredientData[] = [
                'id' => $ingredient->id,
                'name' => $ingredient->name,
            ];
        }


        return [
            'id' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->id),
            'name' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->name),
            'category' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,['id' => $this->category->id,'name' => $this->category->name,'description'=> $this->category->description,'publish' => $this->category->publish]),

            'brand' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,['id' => $this->brand->id,'name' => $this->brand->name,'description'=> $this->brand->description,'shortDescription'=>$this->brand->short_description,'publish' => $this->brand->publish]),

            'price' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,$this->price_with_discount),

            'stock' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,$this->stock_status),

            'publish' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->publish),
            'type' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value, $this->type),

            'description' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->description),
            'imge' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                value: $this->imge),

            'productionDate' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,$this->production_date),

            'expiryStatus' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,$this->expiry_date),

            'reviews' => ReviewResource::collection($this->when(
                $serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value, value:$this->reviews )),

            'averageStars' => $this->when( $serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value, $this->average_star),

            'ingredients' => $this->when($serializedGroup === SerializedGroup::List->value  || $serializedGroup === SerializedGroup::Details->value, $ingredientData),

            'createdAt' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->created_at),
            'updatedAt' => $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->updated_at),

            'deleteAt' => $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->delete_at)

             ];
    }
}
