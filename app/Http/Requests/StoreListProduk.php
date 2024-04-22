<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListProduk extends FormRequest
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
            'nama_produk' => 'required',
            'harga_beli_produk' => 'required',
            'stok_produk' => 'required',
            'harga_jual_produk' => 'required',
            'kategori_produk' => 'required',
            'deskripsi_produk' => 'required',
            'gambar_produk' => 'required',
        ];

    }

    public function messages() : array {
        
        return [
            'nama_produk.required' => 'Nama produk harus diisi',
            'harga_beli_produk.required' => 'Harga beli produk harus diisi',
            'stok_produk.required' => 'Stok produk harus diisi',
            'harga_jual_produk.required' => 'Harga jual produk harus diisi',
            'kategori_produk.required' => 'Kategori produk harus diisi',
            'deskripsi_produk.required' => 'Deskripsi produk harus diisi',
            'gambar_produk.required' => 'Gambar produk harus diisi',
        ];
    }
}
