<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function listPenjualan()
    {
        return view('admin.transaksi.penjualan.list_penjualan');
    }

    public function addPenjualan()
    {
        return view('admin.transaksi.penjualan.add_penjualan');
    }

    public function savePenjualan()
    {
        return redirect()->route('admin.transaksi.penjualan.list')->with('success', 'Penjualan berhasil ditambahkan');
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
