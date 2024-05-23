<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Produk;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function listPembelian()
    {
        $notificationController = new NotificationController();
        $notification = $notificationController->listNotification();

        $data_pembelian = Produk::leftJoin('pembelians','pembelians.produk_id','=','produks.id')
        ->leftJoin('stoks','stoks.produk_id','=','produks.id')
        ->select('produks.nama as nama', 'stoks.jumlah as stok', 'pembelians.total_harga as harga_beli','pembelians.kuantitas as kuantitas','pembelians.created_at as created_at')
        ->get();

        foreach ($data_pembelian as $pembelian) {
            $pembelian->tanggal = date('d-m-Y', strtotime($pembelian->created_at));
        }
        $compact = [
            'notification' => $notification,
            'data_pembelian' => $data_pembelian,
        ];
        return view('admin.transaksi.pembelian.list_pembelian',$compact);
    }
}
