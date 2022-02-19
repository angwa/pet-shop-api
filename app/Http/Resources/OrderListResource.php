<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "products" => $this->products,
            "address" => $this->address,
            "delivery_fee" => $this->delivery_fee,
            "order_status" => new OrderStatusResource($this->orderStatus),
            "payment" => new PaymentResource($this->payment),
            "amount" => $this->amount,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "shipped_at" => $this->shipped_at,
        ];
    }
}
