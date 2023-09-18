<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'position_title' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'numeric', 'gte:0'],
            'dob' => ['required', 'date', 'date_format:d/m/Y'],
            'city' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'numeric'],
            'avatar' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}
