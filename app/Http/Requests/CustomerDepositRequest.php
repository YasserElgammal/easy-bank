<?php

namespace App\Http\Requests;

use App\Enums\V1\PaymentStatus;
use App\Enums\V1\PaymentType;
use Illuminate\Foundation\Http\FormRequest;

class CustomerDepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $payment_type = join(',', PaymentType::values());

        return [
            'amount' => 'required|numeric|gt:0',
            'description' => 'nullable|max:255',
            'payment_type' =>  "required|in:{$payment_type}",
        ];
    }
}
