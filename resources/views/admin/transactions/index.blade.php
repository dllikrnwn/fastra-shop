@extends('layouts.admin')
@section('title', 'Kelola Transaksi — Admin')

@section('slot')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="nb-btn-ghost inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
        <div>
            <h1 class="section-title">Kelola Transaksi</h1>
            <p class="section-subtitle mt-1">Total {{ $transactions->total() }} transaksi</p>
        </div>
    </div>

    <div class="nb-card-static overflow-hidden">
        <div class="p-4" style="border-bottom: 2px solid var(--border);">
            <form method="GET" class="space-y-3 sm:space-y-0 sm:flex sm:flex-wrap sm:items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice/nama..." class="nb-input py-2 text-sm flex-1 max-w-sm">
                <select name="status" class="nb-input py-2 text-sm w-40">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="nb-btn-secondary text-sm px-4 py-2">Filter</button>
                @if(request('search') || request('status'))<a href="{{ route('admin.transactions.index') }}" class="nb-btn-ghost text-sm px-3 py-2">Reset</a>@endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[700px]">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border);">
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Invoice</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Pembeli</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Game</th>
                        <th class="text-right px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Total</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Status</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Tanggal</th>
                        <th class="text-right px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: var(--border);">
                    @forelse($transactions as $tx)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td class="px-4 py-3 font-mono text-xs font-bold" style="color: var(--text-primary);">{{ $tx->invoice }}</td>
                        <td class="px-4 py-3">
                            <p class="text-gray-900 dark:text-white font-medium">{{ $tx->buyer_name }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $tx->buyer_email }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $tx->game->name ?? '-' }} ({{ $tx->denomination->nominal ?? '-' }})</td>
                        <td class="px-4 py-3 text-right font-mono font-semibold text-accent">{{ $tx->formatted_amount }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                @if($tx->status === 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400
                                @elseif($tx->status === 'awaiting_verification') bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400
                                @elseif($tx->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400
                                @elseif($tx->status === 'failed') bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400
                                @else bg-gray-100 text-gray-600 dark:bg-gray-500/20 dark:text-gray-400 @endif">
                                @if($tx->status === 'awaiting_verification') Menunggu Verifikasi
                                @else {{ ucfirst($tx->status) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $tx->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.transactions.show', $tx) }}" class="nb-btn-ghost px-2 py-1.5 text-xs">Detail</a>
                                @if($tx->status === 'pending')
                                <form method="POST" action="{{ route('admin.transactions.status', $tx) }}" onsubmit="return confirm('Tandai sebagai DIBAYAR?')">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit" class="nb-btn-ghost px-2 py-1.5 text-xs text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-500/10">Bayar</button>
                                </form>
                                <form method="POST" action="{{ route('admin.transactions.status', $tx) }}" onsubmit="return confirm('Tandai sebagai GAGAL?')">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="failed">
                                    <button type="submit" class="nb-btn-ghost px-2 py-1.5 text-xs text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10">Gagal</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-400">Tidak ada transaksi ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4" style="border-top: 2px solid var(--border);">{{ $transactions->links() }}</div>
    </div>
</div>
@endsection
