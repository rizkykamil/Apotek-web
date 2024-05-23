<?php

return [
    // 'merchant_id'    => env('MIDTRANS_MERCHANT_ID', ''),
    // 'client_key'     => env('MIDTRANS_CLIENT_KEY', ''),
    // 'server_key'     => env('MIDTRANS_SERVER_KEY', ''),
    // 'is_production'  => env('MIDTRANS_IS_PRODUCTION', false),
    // 'is_sanitized'   => env('MIDTRANS_IS_SANITIZED', true),
    // 'is_3ds'         => env('MIDTRANS_IS_3DS', true),

    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'sandbox_base_url' => env('MIDTRANS_SANDBOX_BASE_URL'),
    'production_base_url' => env('MIDTRANS_PRODUCTION_BASE_URL'),

];