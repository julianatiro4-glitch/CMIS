@extends('layouts.app')

@section('title', 'Edit Division')
@section('subtitle', $division->name)

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('divisions.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-lg font-bold text-slate-800">Edit Division / Section</h2>
    </div>

    <form method="POST" action="{{ route('divisions.update', $division) }}" class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        @csrf
        @method('PUT')
        @include('divisions._form')
        <div class="flex gap-3 mt-6 pt-4 border-t border-slate-100">
            <button class="px-5 py-2 text-sm font-semibold text-white rounded-lg hover:opacity-90 transition-all"
                    style="background:#0d2a5e;">Save Changes</button>
            <a href="{{ route('divisions.index') }}"
               class="px-5 py-2 text-sm font-medium text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
