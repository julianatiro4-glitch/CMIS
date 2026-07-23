@extends('layouts.app')

@section('title', $asset->asset_tag)
@section('subtitle', $asset->name)

@section('content')

@php
$statusColors = [
    'available' => 'bg-green-100 text-green-700 border-green-200',
    'in_use'    => 'bg-blue-100 text-blue-700 border-blue-200',
    'in_repair' => 'bg-amber-100 text-amber-700 border-amber-200',
    'retired'   => 'bg-slate-100 text-slate-500 border-slate-200',
    'lost'      => 'bg-red-100 text-red-700 border-red-200',
];
$conditionColors = [
    'good'          => 'bg-green-100 text-green-700',
    'fair'          => 'bg-yellow-100 text-yellow-700',
    'for_repair'    => 'bg-orange-100 text-orange-700',
    'unserviceable' => 'bg-red-100 text-red-700',
];
@endphp

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
    <div class="flex items-start gap-3">
        <a href="{{ route('assets.index') }}"
           class="mt-1 text-slate-400 hover:text-slate-600 transition-colors flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="font-mono text-sm font-bold bg-slate-100 px-3 py-1 rounded-lg text-slate-700">
                    {{ $asset->asset_tag }}
                </span>
                @if ($asset->condition)
                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $conditionColors[$asset->condition] ?? 'bg-slate-100 text-slate-500' }}">
                    {{ ucfirst(str_replace('_', ' ', $asset->condition)) }}
                </span>
                @endif
            </div>
            <h2 class="text-lg font-bold text-slate-800 mt-1">{{ $asset->name }}</h2>

        </div>
    </div>
    <div class="flex flex-wrap gap-2 flex-shrink-0">
        <a href="{{ route('assets.label', $asset) }}" target="_blank"
           class="flex items-center gap-1.5 text-xs font-medium px-3 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors text-slate-600">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M7 7h.01M17 7h.01M7 17h.01"/>
            </svg>
            Print Label
        </a>
        <a href="{{ route('assets.edit', $asset) }}"
           class="flex items-center gap-1.5 text-xs font-semibold px-4 py-2 rounded-lg text-white hover:opacity-90 transition-all"
           style="background:#0d2a5e;">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit Asset
        </a>
    </div>
</div>

{{-- Main layout: 2/3 left + 1/3 right on desktop, stacked on mobile --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- LEFT COLUMN (spans 2 on desktop) --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Hardware Specifications --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2" style="background:#f0f7ff;">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                </svg>
                <h3 class="font-bold text-slate-800 text-sm">Hardware Specifications</h3>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">CPU / Processor</p>
                    <p class="text-sm font-semibold text-slate-800 leading-snug">
                        {{ $asset->cpu ?: '—' }}
                    </p>
                </div>

                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">RAM / Memory</p>
                    <p class="text-sm font-semibold text-slate-800">
                        {{ $asset->ram_total ?: '—' }}
                        @if ($asset->ram_used)
                            <span class="text-xs font-normal text-slate-400 ml-1">({{ $asset->ram_used }} used)</span>
                        @endif
                    </p>
                </div>

                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Storage Capacity</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $asset->storage_capacity ?: '—' }}</p>
                </div>



                <div class="bg-slate-50 rounded-xl p-4 sm:col-span-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Operating System</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $asset->operating_system ?: '—' }}</p>
                </div>


                <div class="bg-slate-50 rounded-xl p-4 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 {{ $asset->has_crowdstrike ? 'bg-green-100' : 'bg-slate-100' }}">
                        <svg class="w-4 h-4 {{ $asset->has_crowdstrike ? 'text-green-600' : 'text-slate-400' }}"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">CrowdStrike</p>
                        <p class="text-sm font-semibold {{ $asset->has_crowdstrike ? 'text-green-600' : 'text-slate-500' }}">
                            {{ $asset->has_crowdstrike ? 'Installed' : 'Not Installed' }}
                        </p>
                    </div>
                </div>

                @if ($asset->software_installed)
                <div class="bg-slate-50 rounded-xl p-4 sm:col-span-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Software Installed</p>
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $asset->software_installed }}</p>
                </div>
                @endif

            </div>
        </div>

        {{-- Division & User --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2" style="background:#faf5ff;">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <h3 class="font-bold text-slate-800 text-sm">Division & User Details</h3>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Division / Section</p>
                    @if ($asset->division)
                        <span class="inline-block font-mono font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded text-xs mb-1">
                            {{ $asset->division->code }}
                        </span>
                        <p class="text-sm font-semibold text-slate-800">{{ $asset->division->name }}</p>
                    @else
                        <p class="text-sm text-slate-400">—</p>
                    @endif
                </div>

                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Utilized By</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $asset->utilized_by ?: '—' }}</p>
                </div>


                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Connectivity</p>
                    <p class="text-sm font-semibold text-slate-800">
                        {{ strtoupper($asset->connectivity ?? 'LAN') }}
                        @if ($asset->wifi_network)
                            <span class="text-slate-400 text-xs font-normal ml-1">({{ $asset->wifi_network }})</span>
                        @endif
                    </p>
                </div>

                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Ownership</p>
                    <p class="text-sm font-semibold text-slate-800">
                        {{ ucfirst(str_replace('_', ' ', $asset->ownership_type ?? 'office_owned')) }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Notes --}}
        @if ($asset->notes || $asset->specifications)
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
            <h3 class="font-bold text-slate-800 text-sm mb-3">Notes & Remarks</h3>
            @if ($asset->notes)
            <p class="text-sm text-slate-600 leading-relaxed">{{ $asset->notes }}</p>
            @endif
            @if ($asset->specifications)
            <p class="text-sm text-slate-600 leading-relaxed mt-2">{{ $asset->specifications }}</p>
            @endif
        </div>
        @endif

    </div>

    {{-- RIGHT COLUMN --}}
    <div class="space-y-5">

        {{-- Basic Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2" style="background:#f8fafc;">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <h3 class="font-bold text-slate-800 text-sm">Basic Information</h3>
            </div>
            <div class="p-5 space-y-3">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Category</p>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $asset->category?->name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Serial Number</p>
                    <p class="text-sm font-mono font-semibold text-slate-800 mt-0.5">{{ $asset->serial_number ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Condition</p>
                    <span class="inline-block mt-0.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $conditionColors[$asset->condition ?? 'good'] ?? 'bg-slate-100 text-slate-500' }}">
                        {{ ucfirst(str_replace('_', ' ', $asset->condition ?? 'good')) }}
                    </span>
                </div>
            </div>
        </div>



        {{-- Record timestamps --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
            <h3 class="font-bold text-slate-800 text-sm mb-3">Record</h3>
            <div class="space-y-2">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Added</p>
                    <p class="text-xs text-slate-600 mt-0.5">{{ $asset->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Last Updated</p>
                    <p class="text-xs text-slate-600 mt-0.5">{{ $asset->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
