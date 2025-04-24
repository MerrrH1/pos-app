<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|max:255|unique:products,name,' . $this->route('product')->id,
            'category_id' => 'required|numeric|exists:categories,id',
            'unit_id' => 'required|numeric|exists:units,id',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama produk harus diisi',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter',
            'name.unique' => 'Nama produk sudah ada',
            'category_id.required' => 'Kategori produk harus dipilih',
            'category_id.numeric' => 'Kategori produk harus berupa angka',
            'category_id.exists' => 'Kategori produk tidak ditemukan',
            'unit_id.required' => 'Satuan produk harus dipilih',
            'unit_id.numeric' => 'Satuan produk harus berupa angka',
            'unit_id.exists' => 'Satuan produk tidak ditemukan',
            'price.required' => 'Harga produk harus diisi',
            'price.numeric' => 'Harga produk harus berupa angka',
            'price.min' => 'Harga produk tidak boleh kosong',
            'cost.required' => 'Biaya produk harus diisi',
            'cost.numeric' => 'Biaya produk harus berupa angka',
            'cost.min' => 'Biaya produk tidak boleh kosong',
            'stock.required' => 'Stok produk harus diisi',
            'stock.numeric' => 'Stok produk harus berupa angka',
            'stock.min' => 'Stok produk tidak boleh kosong'
        ];
    }
}
