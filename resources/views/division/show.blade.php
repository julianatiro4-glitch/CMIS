@extends('layouts.app')

@section('title', $location->name)
@section('subtitle', 'Location detail and divisions')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('locations.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h2 class="text-lg font-bold text-slate-800">{{ $location->name }}</h2>
        <p class="text-sm text-slate-500">
            {{ collect([$location->building, $location->floor, $location->room])->filter()->implode(' · ') ?: 'No additional details' }}
        </p>
    </div>
    <div class="ml-auto flex gap-2">
        <a href="{{ route('locations.edit', $location) }}"
           class="text-xs font-medium text-slate-600 border border-slate-200 px-3 py-1.5 rounded-lg hover:bg-slate-50">Edit Location</a>
        <a href="{{ route('divisions.create') }}?location_id={{ $location->id }}"
           class="flex items-center gap-1.5 text-xs font-semibold text-white px-4 py-1.5 rounded-lg hover:opacity-90"
           style="background:#0d2a5e;">
            + Add Division
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 21h18M3 7v1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7H3l2-4h14l2 4"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $divisions->count() }}</p>
            <p class="text-xs text-slate-400">Divisions / Sections</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-slate-800">{{ $location->assets_count }}</p>
            <p class="text-xs text-slate-400">Total Assets</p>
        </div>
    </div>
</div>

{{-- Divisions table --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100">
    <div class="px-5 py-4 border-b border-slate-100">
        <h3 class="font-bold text-slate-800 text-sm">Divisions / Sections</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide border-b border-slate-100">
                    <th class="px-5 py-3">Division</th>
                    <th class="px-5 py-3">Code</th>
                    <th class="px-5 py-3">Description</th>
                    <th class="px-5 py-3"># Assets</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($divisions as $division)
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3 font-semibold text-slate-800">{{ $division->name }}</td>
                    <td class="px-5 py-3">
                        @if ($division->code)
                            <span class="px-2 py-1 rounded text-xs font-mono font-bold bg-blue-50 text-blue-700">{{ $division->code }}</span>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-slate-500 text-xs">{{ $division->description ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                            {{ $division->assets_count }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('divisions.edit', $division) }}" class="text-xs text-amber-600 hover:underline font-medium">Edit</a>
                            <a href="{{ route('assets.index', ['division_id' => $division->id]) }}" class="text-xs text-blue-600 hover:underline font-medium">View Assets</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center">
                        <p class="text-slate-500 text-sm">No divisions yet for this location.</p>
                        <a href="{{ route('divisions.create') }}" class="inline-block mt-2 text-xs font-semibold text-white px-4 py-2 rounded-lg" style="background:#0d2a5e;">+ Add Division</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
