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
                'ewallet_name' => 'GoPay',
                'ewallet_number' => '628815381632',
                'ewallet_holder' => 'Fastra Shop',
                'qris_image' => '',
            ];
            return $defaults[$key] ?? $default;
        }

        $settings = json_decode(Storage::disk('local')->get('settings/payment.json'), true);
        return $settings[$key] ?? $default;
    }
}
