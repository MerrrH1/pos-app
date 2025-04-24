<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists' => 'Customer does not exist.',
            'date.required' => 'Date is required.',
            'date.date' => 'Date must be a valid date.'
        ];
    }
}
