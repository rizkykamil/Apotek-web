<?php

namespace App\Http\Controllers\admin;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$clientKey = config('midtrans.client_key');
        Config::$is3ds = true;
        Config::$isSanitized = true;

        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $request->amount,
            ],
            'credit_card' => [
                'secure' => true,
                'card_number' => $request->card_number,
                'card_exp_month' => $request->card_exp_month,
                'card_exp_year' => $request->card_exp_year,
                'card_cvv' => $request->card_cvv,
                'card_holder_name' => $request->card_holder_name,
            ],
            'customer_details' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function handleNotification(Request $request)
    {
        $notification = new \Midtrans\Notification();
        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        // Handle notification logic here

        return response()->json(['status' => 'success']);
    }

}
