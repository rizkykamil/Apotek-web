<?php

namespace App\Http\Controllers\admin;

use App\Models\Stok;
use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Exports\PenjualanExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;


class PenjualanController extends Controller
{
    public function listPenjualan()
    {
        $data_penjualan = Penjualan::get();
        foreach ($data_penjualan as $penjualan) {
            $penjualan->tanggal = date('d-m-Y', strtotime($penjualan->created_at));
        }

        $data_produk = Produk::select('id','nama')->get();
        foreach ($data_produk as $produk) {
            $produk->harga_jual = Produk::find($produk->id)->harga_jual;
        }
        $notificationController = new NotificationController();
        $notification = $notificationController->listNotification();

        $compact = [
            'data_penjualan' => $data_penjualan,
            'data_produk' => $data_produk,
            'notification' => $notification,
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
            'total_harga' => 'required',
            'produk' => 'required',
        ]);

        $stok = Stok::where('produk_id', $request->produk)->first();
        if($stok->jumlah < $request->kuantitas){
            return back()->with('error', 'Stok tidak mencukupi');
        }
        $stok->jumlah -= $request->kuantitas;

        $stok->save();

        $penjualan = new Penjualan();
        $penjualan->produk_id = $request->produk;
        $penjualan->kuantitas = $request->kuantitas;
        $penjualan->total_harga = $request->total_harga;
        $penjualan->save();


        return redirect()->route('admin.transaksi.penjualan.list')->with('success', 'Penjualan berhasil disimpan');
    }

    public function filterPenjualan(Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $data_penjualan = Penjualan::
        join('produks', 'penjualans.produk_id', '=', 'produks.id')->
        whereBetween('penjualans.created_at', [$start_date, $end_date])
        ->select('penjualans.*', 'produks.nama as produk')
        ->get();

        $data_penjualan->map(function ($penjualan) {
            $penjualan->tanggal = date('d-m-Y', strtotime($penjualan->created_at));
        });
        
        return json_encode($data_penjualan);
    }

    public function printPenjualan(Request $request) {
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        $data_penjualan = Penjualan::
        join('produks', 'penjualans.produk_id', '=', 'produks.id')->
        whereBetween('penjualans.created_at', [$startDate, $endDate])
        ->select('penjualans.*', 'produks.nama as produk')
        ->get();

        $data_penjualan->map(function ($penjualan) {
            $penjualan->tanggal = date('d-m-Y', strtotime($penjualan->created_at));
        });

        $compact = [
            'data_penjualan' => $data_penjualan,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        return response()->json(['data' => $compact]);
    }

    public function exportExcel(Request $request) {
        $tanggal_awal = $request->startDate;
        $tanggal_akhir = $request->endDate;
        return Excel::download(new PenjualanExport($tanggal_awal,$tanggal_akhir), 'penjualan'.$tanggal_awal.'-'.$tanggal_akhir.'.xlsx');
    }
    
}
