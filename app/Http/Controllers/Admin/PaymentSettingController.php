<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentSettingController extends Controller
{
    private const DEFAULT_EWALLETS = [
        'gopay' => ['name' => 'GoPay', 'number' => '628815381632', 'holder' => 'Fastra Shop'],
        'ovo' => ['name' => 'OVO', 'number' => '', 'holder' => ''],
        'dana' => ['name' => 'DANA', 'number' => '', 'holder' => ''],
        'shopeepay' => ['name' => 'ShopeePay', 'number' => '', 'holder' => ''],
    ];

    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.payment-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'wa_number' => 'required|string|max:20',
            'bank_name' => 'required|string|max:100',
            'bank_account' => 'required|string|max:50',
            'bank_holder' => 'required|string|max:255',
            'ewallets' => 'required|array',
            'ewallets.*.name' => 'required|string|max:50',
            'ewallets.*.number' => 'nullable|string|max:50',
            'ewallets.*.holder' => 'nullable|string|max:100',
            'qris_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'wa_number' => $validated['wa_number'],
            'bank_name' => $validated['bank_name'],
            'bank_account' => $validated['bank_account'],
            'bank_holder' => $validated['bank_holder'],
            'ewallets' => $validated['ewallets'],
            'qris_image' => $this->getSettings()['qris_image'] ?? '',
        ];

        if ($request->hasFile('qris_image')) {
            if (!empty($data['qris_image'])) {
                Storage::disk('public')->delete($data['qris_image']);
            }
            $data['qris_image'] = $request->file('qris_image')->store('payments', 'public');
        }

        $this->saveSettings($data);

        return redirect()->route('admin.payment-settings')->with('success', 'Pengaturan pembayaran berhasil disimpan');
    }

    private function getSettings(): array
    {
        if (!Storage::disk('local')->exists('settings/payment.json')) {
            return [
                'wa_number' => '628815381632',
                'bank_name' => 'Seabank',
                'bank_account' => '901615310372',
                'bank_holder' => 'Fastra Shop',
                'ewallets' => self::DEFAULT_EWALLETS,
                'qris_image' => '',
            ];
        }
        return json_decode(Storage::disk('local')->get('settings/payment.json'), true);
    }

    private function saveSettings(array $data): void
    {
        if (!Storage::disk('local')->exists('settings')) {
            Storage::disk('local')->makeDirectory('settings');
        }
        Storage::disk('local')->put('settings/payment.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}
