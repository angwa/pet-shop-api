<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
           // "uuid" => $this->uuid,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "avatar" => $this->avatar,
            "phone_number" => $this->phone_number,
            "is_marketing" => $this->is_marketing,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
