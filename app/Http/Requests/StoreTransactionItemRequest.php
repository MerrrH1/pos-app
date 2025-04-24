<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionItemRequest extends FormRequest
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
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'transaction_id.required' => 'Transaksi tidak boleh kosong.',
            'transaction_id.exists' => 'Transaksi tidak ditemukan.',
            'product_id.required' => 'Produk harus dipilih.',
            'product_id.exists' => 'Produk tidak valid.',
            'quantity.required' => 'Jumlah produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka.',
            'quantity.min' => 'Jumlah produk minimal 1.'
        ];
    }
}
