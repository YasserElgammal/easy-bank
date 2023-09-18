<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dob' => $this->dob,
            'phone' => $this->phone,
            'balance' => $this->balance,
            'user' => UserResource::make($this->whenLoaded('user'))
        ];
    }
}
