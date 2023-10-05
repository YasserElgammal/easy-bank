<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerDepositResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'description' => $this->description,
            'payment_status' => $this->payment_status,
            'payment_type' => $this->payment_type,
            'approved_by' => UserResource::make($this->whenLoaded('user'))
        ];
    }
}
