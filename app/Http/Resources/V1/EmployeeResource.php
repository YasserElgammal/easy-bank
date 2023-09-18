<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dob' => $this->dob,
            'phone' => $this->phone,
            'city' => $this->city,
            'avatar' => $this->avatar,
            'position_title' => $this->position_title,
            'salary' => $this->salary,
            'phone' => $this->phone,
            'user' => UserResource::make($this->whenLoaded('user'))
        ];
    }
}
