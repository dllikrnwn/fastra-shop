@extends('layouts.admin')
@section('title', 'Pengaturan Pembayaran — Admin')

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="nb-btn-ghost p-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        </a>
        <h1 class="section-title">Pengaturan Pembayaran</h1>
    </div>

    <form method="POST" action="{{ route('admin.payment-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        {{-- WhatsApp Admin --}}
        <div class="nb-card-static p-6">
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4">Notifikasi WhatsApp</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">No WhatsApp Admin</label>
                <input type="text" name="wa_number" value="{{ old('wa_number', payment_setting('wa_number')) }}" class="nb-input" placeholder="628xxxxxxxxxxxx">
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Format: kode negara + nomor (contoh: 628815381632)</p>
            </div>
        </div>

        {{-- Data Rekening --}}
        <div class="nb-card-static p-6">
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4">Data Rekening Bank</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Bank</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', payment_setting('bank_name')) }}" class="nb-input" placeholder="Seabank">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">No Rekening</label>
                    <input type="text" name="bank_account" value="{{ old('bank_account', payment_setting('bank_account')) }}" class="nb-input" placeholder="901615310372">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Pemilik Rekening</label>
                    <input type="text" name="bank_holder" value="{{ old('bank_holder', payment_setting('bank_holder')) }}" class="nb-input" placeholder="Nama sesuai di buku tabungan">
                </div>
            </div>
        </div>

        {{-- E-Wallet --}}
        <div class="nb-card-static p-6">
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4">E-Wallet</h2>
            @php $ew = old('ewallets', payment_setting('ewallets', [])); @endphp
            @foreach(['gopay' => 'GoPay', 'ovo' => 'OVO', 'dana' => 'DANA', 'shopeepay' => 'ShopeePay'] as $key => $label)
            <div class="p-4 mb-4 rounded-xl" style="border: 2px solid var(--border);">
                <p class="font-display font-bold text-sm mb-3" style="color: var(--text-primary);">{{ $label }}</p>
                <input type="hidden" name="ewallets[{{ $key }}][name]" value="{{ $label }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold mb-1" style="color: var(--text-secondary);">No HP</label>
                        <input type="text" name="ewallets[{{ $key }}][number]" value="{{ $ew[$key]['number'] ?? '' }}" class="nb-input py-2 text-sm" placeholder="628xxxxxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1" style="color: var(--text-secondary);">Nama Pemilik</label>
                        <input type="text" name="ewallets[{{ $key }}][holder]" value="{{ $ew[$key]['holder'] ?? '' }}" class="nb-input py-2 text-sm" placeholder="Fastra Shop">
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- QRIS --}}
        <div class="nb-card-static p-6">
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4">QRIS</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Gambar QRIS</label>
                @if(payment_setting('qris_image') && \Illuminate\Support\Facades\Storage::disk('public')->exists(payment_setting('qris_image')))
                <div class="mb-3">
                    <img src="{{ asset('storage-files/' . payment_setting('qris_image')) }}" alt="QRIS" class="w-40 h-40 object-contain rounded-xl border border-gray-200 dark:border-surface-dark-border p-2 bg-white">
                </div>
                @endif
                <input type="file" name="qris_image" accept="image/*" class="nb-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-[2px] file:border-black file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20 file:cursor-pointer">
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Upload gambar QRIS statis dari bank/e-wallet kamu. Format: JPG, PNG. Maks 2MB.</p>
            </div>
        </div>

        <button type="submit" class="nb-btn-primary shadow-glow-sm hover:shadow-glow">Simpan Pengaturan</button>
    </form>
</div>
@endsection
