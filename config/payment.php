<?php

return [
    'wa_number' => env('PAYMENT_WA_NUMBER', '628815381632'),
    'bank_name' => env('PAYMENT_BANK_NAME', 'Seabank'),
    'bank_account' => env('PAYMENT_BANK_ACCOUNT', '901615310372'),
    'bank_holder' => env('PAYMENT_BANK_HOLDER', 'Fastra Shop'),
    'ewallet_name' => env('PAYMENT_EWALLET_NAME', 'GoPay'),
    'ewallet_number' => env('PAYMENT_EWALLET_NUMBER', '628815381632'),
    'ewallet_holder' => env('PAYMENT_EWALLET_HOLDER', 'Fastra Shop'),
    'qris_image' => env('PAYMENT_QRIS_IMAGE', 'payments/qris.png'),
];
