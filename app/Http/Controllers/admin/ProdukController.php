<?php

namespace App\Http\Controllers\admin;

use App\Models\Stok;
use App\Models\Produk;
use App\Models\JenisProduk;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreListProduk;

class ProdukController extends Controller
{
    public function listProduk()
    {
        $kategori_produks = JenisProduk::all();
        $list_produk = Produk::all();
        $compact = [
            'kategori_produks' => $kategori_produks,
            'list_produk' => $list_produk
        ];
        return view('admin.produk.list_produk', $compact);
    }
    public function saveProduk(StoreListProduk $request):RedirectResponse
    {
        $data = new Produk();
        if ($request->hasFile('gambar_produk')){
            $file = $request->file('gambar_produk');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move('img/image_obat', $filename);
            $data->gambar = $filename;
        }
        $data->gambar = $filename;
        $data->nama = $request->nama_produk;
        $data->harga_beli = $request->harga_beli_produk;
        $data->harga_jual = $request->harga_jual_produk;
        $data->deskripsi = $request->deskripsi_produk;
        $data->jenis_produk_id = $request->kategori_produk;
        $data->slug = Str::slug($request->nama_produk);
        $data->save();

        $data_stok = new Stok();
        $data_stok->produk_id = $data->id;
        $data_stok->jumlah = $request->stok_produk;
        $data_stok->save();

        return redirect()->route('admin.produk.list')->with('success', 'Produk berhasil ditambahkan');
    }

    public function viewProduk($slug)
    {
        $list_produk = Produk::where('slug', $slug)->first();
        $compact = [
            'list_produk' => $list_produk
        ];
        return view('admin.produk.view_produk',$compact);
    }
    

    public function editProduk($id)
    {
        $data_produk = Produk::join('jenis_produks', 'produks.jenis_produk_id', '=', 'jenis_produks.id')
            ->join('stoks', 'produks.id', '=', 'stoks.produk_id')
            ->select('produks.*', 'jenis_produks.nama as jenis_produk', 'stoks.jumlah')
            ->where('produks.id', $id)
            ->first();
        $compact = [
            'data_produk' => $data_produk,
        ];
        return json_encode($compact);
    }

    public function updateProduk(StoreListProduk $request, $id)
    {
        $data = Produk::find($id);
        if ($request->hasFile('gambar_produk')){
            $file = $request->file('gambar_produk');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move('img/image_obat', $filename);
            $data->gambar = $filename;
        }
        $data->gambar = $filename;
        $data->nama = $request->nama_produk;
        $data->harga_beli = $request->harga_beli_produk;
        $data->harga_jual = $request->harga_jual_produk;
        $data->deskripsi = $request->deskripsi_produk;
        $data->jenis_produk_id = $request->kategori_produk;
        $data->slug = Str::slug($request->nama_produk);
        $data->update();

        $data_stok = Stok::where('produk_id', $id)->first();
        $data_stok->jumlah = $request->stok_produk;
        $data_stok->update();

        return redirect()->back()->with('success', 'Produk berhasil diupdate');

    }

    public function deleteProduk($id)
    {
        $data = Produk::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }
}
