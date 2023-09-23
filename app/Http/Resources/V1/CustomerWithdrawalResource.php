<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerWithdrawalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'is_approved' => $this->is_approved,
            'description' => $this->description,
            'description' => $this->description,
            'approved_by' => UserResource::make($this->whenLoaded('user'))
        ];
    }
}
