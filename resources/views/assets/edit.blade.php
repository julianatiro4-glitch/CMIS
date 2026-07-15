@extends('layouts.app')
@section('title', 'Edit — ' . $asset->asset_tag)
@section('subtitle', $asset->name)
@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('assets.show', $asset) }}" class="text-slate-400 hover:text-slate-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h2 class="text-lg font-bold text-slate-800">Edit Asset</h2>
        <p class="text-sm text-slate-400">{{ $asset->asset_tag }} — {{ $asset->name }}</p>
    </div>
</div>
<form method="POST" action="{{ route('assets.update', $asset) }}" class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
    @method('PUT')
    @include('assets._form')
    <div class="flex gap-3 mt-6 pt-5 border-t border-slate-100">
        <button class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg hover:opacity-90 shadow" style="background:#0d2a5e;">Save Changes</button>
        <a href="{{ route('assets.show', $asset) }}" class="px-6 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">Cancel</a>
    </div>
</form>
@endsection
