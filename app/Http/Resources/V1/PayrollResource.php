<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'salary' => $this->salary,
            'notes' => $this->notes,
            'employee' => EmployeeResource::make($this->whenLoaded('employee'))
        ];
    }
}
