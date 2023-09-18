<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'description' => $this->description,
            'senderUser' => CustomerResource::make($this->whenLoaded('senderUser')),
            'receiverUser' => CustomerResource::make($this->whenLoaded('receiverUser'))
        ];
    }
}
