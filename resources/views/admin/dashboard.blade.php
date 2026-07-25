@extends('layouts.admin')
@section('title', 'Admin Dashboard — Fastra Shop')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
@endsection

@section('slot')
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="section-title mb-8">Admin Dashboard</h1>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-10">
        @php $stats = [
            ['label' => 'Users', 'value' => $totalUsers, 'color' => 'var(--accent)'],
            ['label' => 'Games', 'value' => $totalGames, 'color' => 'var(--neo-yellow)'],
            ['label' => 'Transaksi', 'value' => $totalTransactions, 'color' => 'var(--neo-green)'],
            ['label' => 'Revenue', 'value' => 'Rp ' . number_format($revenue, 0, ',', '.'), 'color' => 'var(--accent)'],
            ['label' => 'Menunggu', 'value' => $pendingCount, 'color' => 'var(--neo-orange)'],
        ]; @endphp
        @foreach($stats as $s)
        <div class="nb-card-static p-4 text-center">
            <p class="text-xs font-display font-bold uppercase tracking-widest" style="color: var(--text-secondary);">{{ $s['label'] }}</p>
            <p class="font-display font-black text-2xl md:text-3xl mt-2" style="color: {{ $s['color'] }};">{{ $s['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Chart + Top Games --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <div class="lg:col-span-2 nb-card-static p-6">
            <h2 class="font-display font-bold text-lg mb-4" style="color: var(--text-primary);">Revenue 12 Bulan</h2>
            <div style="height:280px"><canvas id="revenueChart"></canvas></div>
        </div>
        <div class="nb-card-static p-6">
            <h2 class="font-display font-bold text-lg mb-4" style="color: var(--text-primary);">Top Games</h2>
            <div class="space-y-0">
                @forelse($topGames as $tg)
                <div class="flex items-center justify-between py-3" style="border-bottom: 1px solid var(--border);">
                    <span class="font-display font-black text-lg w-6" style="color: var(--text-secondary);">{{ $loop->iteration }}</span>
                    <span class="font-display font-bold text-sm flex-1 ml-3" style="color: var(--text-primary);">{{ $tg->game_name }}</span>
                    <span class="font-mono font-bold text-sm" style="color: var(--accent);">{{ $tg->count }}x</span>
                </div>
                @empty
                <p class="text-sm text-center py-8" style="color: var(--text-secondary);">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Pending Verification --}}
    <div class="nb-card-static p-6 mb-10" style="border-color: var(--accent); box-shadow: 4px 4px 0 var(--accent-shadow);">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 flex items-center justify-center font-bold text-sm rounded-lg" style="background: var(--accent); color: #000; border: 2px solid var(--border);">{{ $pendingCount }}</div>
                <h2 class="font-display font-bold text-lg" style="color: var(--text-primary);">Menunggu Verifikasi</h2>
            </div>
            <a href="{{ route('admin.transactions.index', ['status' => 'awaiting_verification']) }}" class="nb-btn-ghost text-sm">Lihat Semua</a>
        </div>
        @forelse($recentTransactions as $tx)
        <div class="flex items-center gap-4 py-3" style="border-bottom: 1px solid var(--border);">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 font-display font-bold text-sm" style="background: var(--accent); color: #000; border: 2px solid var(--border);">{{ substr($tx->buyer_name, 0, 1) }}</div>
            <div class="flex-1 min-w-0">
                <p class="font-display font-bold text-sm" style="color: var(--text-primary);">{{ $tx->buyer_name }}</p>
                <p class="text-xs" style="color: var(--text-secondary);">{{ $tx->game->name ?? '-' }} · {{ $tx->created_at->diffForHumans() }}</p>
            </div>
            <div class="text-right shrink-0">
                <p class="font-mono font-bold text-sm" style="color: var(--accent);">{{ $tx->formatted_amount }}</p>
            </div>
            <div class="flex gap-1">
                <form method="POST" action="{{ route('admin.transactions.status', $tx) }}" onsubmit="return confirm('Approve?')">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="paid">
                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold transition-all" style="background: var(--neo-green); color: #000; border: 2px solid var(--border);">✓</button>
                </form>
                <form method="POST" action="{{ route('admin.transactions.status', $tx) }}" onsubmit="return confirm('Tolak?')">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="failed">
                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold transition-all" style="background: var(--neo-pink); color: #000; border: 2px solid var(--border);">✕</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-sm text-center py-8" style="color: var(--text-secondary);">Semua transaksi sudah diverifikasi ✓</p>
        @endforelse
    </div>

    {{-- Quick Links --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        @php $linkIcons = [
            'Games' => '<path d="M11 17l-5-5 5-5" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 17l-5-5 5-5" stroke-linecap="round" stroke-linejoin="round"/>',
            'Banner' => '<rect x="3" y="5" width="18" height="14" rx="2" stroke-linecap="round"/><circle cx="8.5" cy="9.5" r="1.5" fill="currentColor"/><path d="M21 15l-5-5L5 21" stroke-linecap="round" stroke-linejoin="round"/>',
            'Transaksi' => '<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke-linecap="round"/><rect x="9" y="3" width="6" height="4" rx="1" stroke-linecap="round"/><path d="M9 12h6" stroke-linecap="round"/><path d="M9 16h6" stroke-linecap="round"/>',
            'Users' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke-linecap="round"/><path d="M23 21v-2a4 4 0 00-3-3.87" stroke-linecap="round"/><path d="M16 3.13a4 4 0 010 7.75" stroke-linecap="round"/>',
            'Pembayaran' => '<rect x="1" y="5" width="22" height="14" rx="2" stroke-linecap="round"/><path d="M1 10h22" stroke-linecap="round"/><circle cx="7" cy="15" r="1" fill="currentColor"/>',
        ]; @endphp
        @foreach([
            ['route' => 'admin.games.index', 'label' => 'Games', 'color' => 'var(--accent)'],
            ['route' => 'admin.banners.index', 'label' => 'Banner', 'color' => 'var(--neo-green)'],
            ['route' => 'admin.transactions.index', 'label' => 'Transaksi', 'color' => 'var(--neo-yellow)'],
            ['route' => 'admin.users.index', 'label' => 'Users', 'color' => 'var(--neo-purple)'],
            ['route' => 'admin.payment-settings', 'label' => 'Pembayaran', 'color' => 'var(--neo-orange)'],
        ] as $link)
        <a href="{{ route($link['route']) }}" class="nb-card p-5 text-center hover:-translate-y-1 transition-all">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2" style="background: {{ $link['color'] }}15; border: 2px solid {{ $link['color'] }};">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color: {{ $link['color'] }};">
                    {!! $linkIcons[$link['label']] !!}
                </svg>
            </div>
            <p class="font-display font-bold text-sm" style="color: var(--text-primary);">{{ $link['label'] }}</p>
        </a>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;
    const labels = @json($revenuePerMonth->keys()->map(fn($m) => \Carbon\Carbon::parse($m)->format('M Y')));
    const data = @json($revenuePerMonth->values());
    new Chart(ctx, {
        type: 'bar',
        data: { labels, datasets: [{ label: 'Revenue', data, backgroundColor: '#00E5FF', borderColor: '#000', borderWidth: 3, borderRadius: 6 }] },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw) } } },
            scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + new Intl.NumberFormat('id-ID', {notation:'compact'}).format(v) }, grid: { color: 'rgba(0,0,0,0.06)' } }, x: { grid: { display: false } } }
        }
    });
});
</script>
@endsection