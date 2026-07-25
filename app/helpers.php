<?php

if (!function_exists('payment_setting')) {
    function payment_setting(string $key, mixed $default = null): mixed
    {
        if (!Storage::disk('local')->exists('settings/payment.json')) {
            $defaults = [
                'wa_number' => '628815381632',
                'bank_name' => 'Seabank',
                'bank_account' => '901615310372',
                'bank_holder' => 'Fastra Shop',
                'qris_image' => '',
                'ewallets' => [
                    'gopay' => ['name' => 'GoPay', 'number' => '628815381632', 'holder' => 'Fastra Shop'],
                    'ovo' => ['name' => 'OVO', 'number' => '', 'holder' => 'Fastra Shop'],
                    'dana' => ['name' => 'DANA', 'number' => '', 'holder' => 'Fastra Shop'],
                    'shopeepay' => ['name' => 'ShopeePay', 'number' => '', 'holder' => 'Fastra Shop'],
                ],
            ];
            return $defaults[$key] ?? $default;
        }

        $settings = json_decode(Storage::disk('local')->get('settings/payment.json'), true);
        return $settings[$key] ?? $default;
    }
}

if (!function_exists('ewallet_data')) {
    function ewallet_data(?string $provider = null): mixed
    {
        $ewallets = payment_setting('ewallets', []);
        if ($provider) {
            return $ewallets[$provider] ?? null;
        }
        return $ewallets;
    }
}
