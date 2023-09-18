<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $getCustomerBalance = auth()->user()->customer->balance;

        return [
            'receiver_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|gt:0|lte:' . $getCustomerBalance,
            'description' => 'nullable|max:255'
        ];
    }
}
