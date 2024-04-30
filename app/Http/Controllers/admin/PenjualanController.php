<?php

namespace App\Http\Controllers\admin;

use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenjualanController extends Controller
{
    public function listPenjualan()
    {
        $data_penjualan = Penjualan::get();
        foreach ($data_penjualan as $penjualan) {
            $penjualan->tanggal = date('d-m-Y', strtotime($penjualan->created_at));
        }

        $data_produk = Produk::select('id','nama')->get();
        // mendapatkan harga_jual sesuai produk
        foreach ($data_produk as $produk) {
            $produk->harga_jual = Produk::find($produk->id)->harga_jual;
        }

        $compact = [
            'data_penjualan' => $data_penjualan,
            'data_produk' => $data_produk,
        ];
        return view('admin.transaksi.penjualan.list_penjualan', $compact);
    }

    public function getProductPrice($id)
    {
        $id = request()->id;
        $harga_jual = Produk::find($id)->harga_jual;
        return response()->json(['harga_jual' => $harga_jual]);
    }

    public function savePenjualan(Request $request)
    {
        $request->validate([
            'kuantitas' => 'required',
            'harga_barang' => 'required',
            'produk' => 'required',
        ]);

        $penjualan = new Penjualan();
        $penjualan->produk_id = $request->produk;
        $penjualan->kuantitas = $request->kuantitas;
        $penjualan->total_harga = $request->harga_barang;
        $penjualan->save();

        return redirect()->route('admin.transaksi.penjualan.list')->with('success', 'Penjualan berhasil disimpan');
    }

    public function editPenjualan($id)
    {
        return view('admin.transaksi.penjualan.edit_penjualan');
    }

    public function updatePenjualan()
    {
        return redirect()->route('admin.transaksi.penjualan.list')->with('success', 'Penjualan berhasil diupdate');
    }

    public function deletePenjualan($id)
    {
        return redirect()->route('admin.transaksi.penjualan.list')->with('success', 'Penjualan berhasil dihapus');
    }
    public function detailPenjualan($id)
    {
        return view('admin.transaksi.penjualan.detail_penjualan');
    }
    
}
