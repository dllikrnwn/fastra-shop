@extends('layouts.admin')
@section('title', 'Kelola User — Admin')

@section('slot')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="nb-btn-ghost inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
        <div>
            <h1 class="section-title">Kelola User</h1>
            <p class="section-subtitle mt-1">Total {{ $users->total() }} user</p>
        </div>
    </div>

    <div class="nb-card-static overflow-hidden">
        <div class="p-4" style="border-bottom: 2px solid var(--border);">
            <form method="GET" class="flex flex-wrap items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="nb-input py-2 text-sm flex-1 max-w-sm">
                <select name="role" class="nb-input py-2 text-sm w-32">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                </select>
                <select name="banned" class="nb-input py-2 text-sm w-36">
                    <option value="">Semua Status</option>
                    <option value="yes" {{ request('banned') === 'yes' ? 'selected' : '' }}>Terban</option>
                    <option value="no" {{ request('banned') === 'no' ? 'selected' : '' }}>Aktif</option>
                </select>
                <button type="submit" class="nb-btn-secondary text-sm px-4 py-2">Filter</button>
                @if(request('search')||request('role')||request('banned'))<a href="{{ route('admin.users.index') }}" class="nb-btn-ghost text-sm px-3 py-2">Reset</a>@endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[600px]">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border);">
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">User</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Email</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Role</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Status</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Bergabung</th>
                        <th class="text-right px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: var(--border);">
                    @forelse($users as $u)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-accent/10 flex items-center justify-center shrink-0">
                                    <span class="font-display font-bold text-sm" style="color: var(--accent);">{{ substr($u->name, 0, 1) }}</span>
                                </div>
                                <span class="font-display font-bold" style="color: var(--text-primary);">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3" style="color: var(--text-secondary);">{{ $u->email }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-lg" style="background: var(--accent); color: #000; border: 2px solid var(--border);">{{ ucfirst($u->role) }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($u->is_banned)
                                <span class="text-xs font-bold px-2 py-0.5 rounded-lg" style="background: var(--neo-pink); color: #000; border: 2px solid var(--border);">Terban</span>
                            @else
                                <span class="text-xs font-bold px-2 py-0.5 rounded-lg" style="background: var(--neo-green); color: #000; border: 2px solid var(--border);">Aktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-xs" style="color: var(--text-secondary);">{{ $u->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            @if(!$u->isAdmin())
                            <form method="POST" action="{{ route('admin.users.toggle-ban', $u) }}" onsubmit="return confirm('{{ $u->is_banned ? 'Unban' : 'Ban' }} user {{ $u->name }}?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="nb-btn-ghost px-2 py-1.5 text-xs" style="color: {{ $u->is_banned ? 'var(--neo-green)' : '#FF4444' }};">
                                    {{ $u->is_banned ? 'Unban' : 'Ban' }}
                                </button>
                            </form>
                            @else
                            <span class="text-xs" style="color: var(--text-secondary);">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center" style="color: var(--text-secondary);">Tidak ada user ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4" style="border-top: 2px solid var(--border);">{{ $users->links() }}</div>
    </div>
</div>
@endsection