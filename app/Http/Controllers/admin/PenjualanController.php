<?php

namespace App\Http\Controllers\admin;

use Midtrans\Snap;
use App\Models\Stok;
use Midtrans\Config;
use App\Models\Produk;
use App\Models\Penjualan;
use Midtrans\Transaction;
use Midtrans\Notification;
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

        $data_produk = Produk::select('id', 'nama')->get();
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
            'kuantitas.*' => 'required',
            'total_harga.*' => 'required',
            'produk.*' => 'required',
        ]);

        $produkArray = $request->produk;
        $kuantitasArray = $request->kuantitas;
        $totalHargaArray = $request->total_harga;

        foreach ($produkArray as $index => $produkId) {
            $kuantitas = $kuantitasArray[$index];
            $totalHarga = $totalHargaArray[$index];

            $stok = Stok::where('produk_id', $produkId)->first();
            if ($stok->jumlah < $kuantitas) {
                return back()->with('error', 'Stok tidak mencukupi untuk produk ID: ' . $produkId);
            }
            $stok->jumlah -= $kuantitas;
            $stok->save();

            $penjualan = new Penjualan();
            $penjualan->produk_id = $produkId;
            $penjualan->kuantitas = $kuantitas;
            $penjualan->status = "success";
            $penjualan->total_harga = $totalHarga;
            $penjualan->save();
        }

        return redirect()->route('admin.transaksi.penjualan.list')->with('success', 'Penjualan berhasil disimpan');
    }

    public function filterPenjualan(Request $request)
    {
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

    public function printPenjualan(Request $request)
    {
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

    public function exportExcel(Request $request)
    {
        $tanggal_awal = $request->startDate;
        $tanggal_akhir = $request->endDate;
        return Excel::download(new PenjualanExport($tanggal_awal, $tanggal_akhir), 'penjualan' . $tanggal_awal . '-' . $tanggal_akhir . '.xlsx');
    }

    public function nonCash(Request $request)
    {

        $produkArray = $request->produk;
        $kuantitasArray = $request->kuantitas;
        $totalHargaArray = $request->total_harga;
        $gross_amount = 0;

        $produkDetails = [];

        foreach ($produkArray as $index => $produkId) {
            $kuantitas = $kuantitasArray[$index];
            $totalHarga = $totalHargaArray[$index];

            $stok = Stok::where('produk_id', $produkId)->first();
            if ($stok->jumlah < $kuantitas) {
                return back()->with('error', 'Stok tidak mencukupi untuk produk ID: ' . $produkId);
            }
            $stok->jumlah -= $kuantitas;
            $stok->save();

            $penjualan = new Penjualan();
            $penjualan->produk_id = $produkId;
            $penjualan->kuantitas = $kuantitas;
            $penjualan->total_harga = $totalHarga;
            $penjualan->save();

            $produkDetails[] = [
                'id_produk' => $produkId,
                'harga' => $totalHarga,
                'jumlah' => $kuantitas,
                'subtotal' => $totalHarga,
            ];

            $gross_amount += $totalHarga;
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$clientKey = config('midtrans.client_key');
        Config::$is3ds = true;
        Config::$isSanitized = true;

        $order_id = uniqid();
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $gross_amount,
            ],
            'produks_details' => $produkDetails
        ];


        try {
            $snapToken = Snap::getSnapToken($params);
            foreach ($produkArray as $index => $produkId) {
                $penjualan = Penjualan::where('produk_id', $produkId)->whereNull('order_id_midtrans')->first();
                if ($penjualan) {
                    $penjualan->order_id_midtrans = $order_id;
                    $penjualan->snap_token = $snapToken;
                    $penjualan->save();
                }
            }
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }



    public function notificationNonCash(Request $request)
    {
        $notification = new Notification();
        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        $penjualans = Penjualan::where('order_id_midtrans', $orderId)->get();

        foreach ($penjualans as $penjualan) {
            if ($penjualan) {
                if ($transaction == 'capture') {
                    if ($type == 'credit_card') {
                        if ($fraud == 'challenge') {
                            $penjualan->status = 'pending';
                        } else {
                            $penjualan->status = 'success';
                        }
                    }
                } else if ($transaction == 'settlement') {
                    $penjualan->status = 'success';
                } else if ($transaction == 'pending') {
                    $penjualan->status = 'pending';
                } else if ($transaction == 'deny') {
                    $penjualan->status = 'cancel';
                } else if ($transaction == 'expire') {
                    $penjualan->status = 'cancel';
                } else if ($transaction == 'cancel') {
                    $penjualan->status = 'cancel';
                }

                $penjualan->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function getSnapTokenByOrderId(Request $request)
    {
        $orderId = $request->order_id;
        $order = Penjualan::where('order_id_midtrans', $orderId)->first();

        if ($order) {
            // // Periksa apakah token Snap sudah kedaluwarsa
            if ($order->status == 'pending' && $this->isSnapTokenExpired($order->snap_token)) {
                $order->status = 'cancel';
                $order->save();
                // refresh halaman
                return response()->json(['error' => 'Token Snap sudah kedaluwarsa'], 404);
            }

            if ($order->status == 'pending') {
                return response()->json(['snap_token' => $order->snap_token]);
            }


        }

        return response()->json(['error' => 'Order not found or not pending'], 404);
    }

    private function isSnapTokenExpired($snapToken)
    {
        // Implementasikan logika untuk memeriksa status token Snap
        // Anda dapat memanggil API Midtrans untuk memeriksa status token
        // Misalnya, menggunakan Midtrans API client untuk memeriksa status transaksi
        try {
            $status = \Midtrans\Transaction::status($snapToken);
            if ($status->transaction_status == 'expire') {
                return true;
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            if ($e->getCode() == 404) {
                return true; // Jika transaksi tidak ditemukan, anggap token sudah kedaluwarsa
            }
        }
        return false;
    }


}


