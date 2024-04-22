<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function listProduk()
    {
        return view('admin.produk.list_produk');
    }

    public function saveProduk(Request $request)
    {
        return redirect()->route('admin.produk.list');
    }

    public function editProduk($id)
    {
        return view('admin.produk.edit_produk');
    }

    public function updateProduk(Request $request, $id)
    {
        return redirect()->route('admin.produk.list');
    }

    public function deleteProduk($id)
    {
        return redirect()->route('admin.produk.list');
    }
}
