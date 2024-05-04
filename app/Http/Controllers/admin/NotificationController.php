<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function listNotification()
{
    $stok = Stok::join('produks','produks.id','=','stoks.produk_id')
    ->select('produks.nama','stoks.jumlah','stoks.updated_at')
    ->where('stoks.jumlah','<=',10)
    ->get();

    $count_notif = $stok->count();

    // Mengubah format tanggal
    $stok->map(function ($item, $key) {
        $item->updated_at = Carbon::parse($item->updated_at)->formatLocalized('%Y-%B-%d');
        return $item;
    });

    $compact = [
        'stok' => $stok,
        'count_notif' => $count_notif
    ];

    return $compact;

}
}
