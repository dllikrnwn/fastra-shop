<?php

return [
    'wa_number' => env('PAYMENT_WA_NUMBER', '628815381632'),
    'bank_name' => env('PAYMENT_BANK_NAME', 'Seabank'),
    'bank_account' => env('PAYMENT_BANK_ACCOUNT', '901615310372'),
    'bank_holder' => env('PAYMENT_BANK_HOLDER', 'Fastra Shop'),
    'qris_image' => env('PAYMENT_QRIS_IMAGE', 'payments/qris.png'),
    'ewallets' => [
        'gopay' => ['name' => 'GoPay', 'number' => '628815381632', 'holder' => 'Fastra Shop'],
        'ovo' => ['name' => 'OVO', 'number' => '628815381632', 'holder' => 'Fastra Shop'],
        'dana' => ['name' => 'DANA', 'number' => '628815381632', 'holder' => 'Fastra Shop'],
        'shopeepay' => ['name' => 'ShopeePay', 'number' => '628815381632', 'holder' => 'Fastra Shop'],
    ],
];
