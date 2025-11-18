<?php

namespace App\Http\Resources;

use App\Constant\SerializedGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
        $cartItems = [];
        foreach ($this->items as $item ) {
            $cartItems[] = [
            'id' => $item->product->id,
            'productName' => $item->product->name ?? null,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'itemTotla' => $item->item_total,
        ];

        }

        return [
            'id' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->id),
            'uuid' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->uuid),

            'user' => $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value,$this->user ?
                    ['userId' => $this->user->id,'userFullName' => $this->user->full_name,] : null),

            'active' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $this->active),

            'items' =>$this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                $cartItems),

            'subtotal' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                (float)$this->subtotal),
            'discount' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                (float)$this->discount),
            'total' => $this->when($serializedGroup === SerializedGroup::Details->value || $serializedGroup === SerializedGroup::List->value,
                (float)$this->total),
            'createdAt' => $this->when(
                $serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->created_at),
            'updatedAt' =>
                $this->when($serializedGroup === SerializedGroup::List->value || $serializedGroup === SerializedGroup::Details->value, $this->updated_at),

        ];
    }
}
