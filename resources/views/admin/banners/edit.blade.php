@extends('layouts.admin')
@section('title', 'Edit Banner — Admin')

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.banners.index') }}" class="nb-btn-ghost p-2"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg></a>
        <h1 class="section-title">Edit: {{ $banner->title }}</h1>
    </div>

    <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        <div class="nb-card-static p-6 space-y-5">
            @include('admin.banners._form', ['banner' => $banner])
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.banners.index') }}" class="nb-btn-secondary flex-1">Batal</a>
            <button type="submit" class="nb-btn-primary flex-1">Update Banner</button>
        </div>
    </form>
</div>
@endsection
