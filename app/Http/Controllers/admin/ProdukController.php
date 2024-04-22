<?php

namespace App\Http\Controllers\admin;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreListProduk;

class ProdukController extends Controller
{
    public function listProduk()
    {
        $kategori_produks = KategoriProduk::all();
        $list_produk = Produk::all();
        $compact = [
            'kategori_produks' => $kategori_produks,
            'list_produk' => $list_produk
        ];
        return view('admin.produk.list_produk', $compact);
    }

    public function addProduk()
    {
        return view('admin.produk.tambah_produk');
    }

    public function saveProduk(StoreListProduk $request):RedirectResponse
    {
        $data = new Produk();
        if ($request->hasFile('gambar_produk')){
            $file = $request->file('gambar_produk');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move('img/image_obat', $filename);
            $data->gambar_produk = $filename;
        }
        $data->gambar_produk = $filename;
        $data->nama_produk = $request->nama_produk;
        $data->harga_beli_produk = $request->harga_beli_produk;
        $data->harga_jual_produk = $request->harga_jual_produk;
        $data->deskripsi_produk = $request->deskripsi_produk;
        $data->stok_produk = $request->stok_produk;
        $data->kategori_produk_id = $request->kategori_produk;
        $data->slug = Str::slug($request->nama_produk);
        $data->save();
        return redirect()->route('admin.produk.list')->with('success', 'Produk berhasil ditambahkan');
    }

    public function viewProduk($id)
    {
        return view('admin.produk.view_produk');
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
