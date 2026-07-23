@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Overview of all office equipment and assets')

@section('content')

{{-- Welcome bar --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <div>
        <h2 class="text-lg font-bold text-slate-800">
            Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }},
            {{ explode(' ', auth()->user()->name)[0] }}
        </h2>
        <p class="text-sm text-slate-400 mt-0.5">{{ now()->format('l, F d, Y') }}</p>
    </div>
    @if (auth()->user()->isAdmin())
    <a href="{{ route('users.index') }}"
       class="flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition-colors text-slate-700 self-start">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Manage Users
    </a>
    @endif
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</p>
        <p class="text-xs text-slate-400 mt-0.5">Total Assets</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 13.01 9 10.01"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-green-600">{{ $stats['good'] }}</p>
        <p class="text-xs text-slate-400 mt-0.5">Good</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-yellow-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['fair'] }}</p>
        <p class="text-xs text-slate-400 mt-0.5">Fair</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-orange-600">{{ $stats['for_repair'] }}</p>
        <p class="text-xs text-slate-400 mt-0.5">For Repair</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-red-600">{{ $stats['unserviceable'] }}</p>
        <p class="text-xs text-slate-400 mt-0.5">Unserviceable</p>
    </div>
</div>

{{-- Attention summary --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Needs attention</h3>
            <p class="text-xs text-slate-400 mt-0.5">A quick snapshot of items that need follow-up</p>
        </div>
        <span class="text-xs bg-red-50 text-red-700 px-2.5 py-1 rounded-full font-semibold">Priority view</span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="rounded-lg border border-red-100 bg-red-50 p-3">
            <p class="text-2xl font-bold text-red-700">{{ $attentionSummary['open_tickets'] }}</p>
            <p class="text-xs text-red-600 mt-1">Open tickets</p>
        </div>
        <div class="rounded-lg border border-amber-100 bg-amber-50 p-3">
            <p class="text-2xl font-bold text-amber-700">{{ $attentionSummary['warranty_alerts'] }}</p>
            <p class="text-xs text-amber-700 mt-1">Warranty alerts</p>
        </div>
        <div class="rounded-lg border border-blue-100 bg-blue-50 p-3">
            <p class="text-2xl font-bold text-blue-700">{{ $attentionSummary['in_repair'] }}</p>
            <p class="text-xs text-blue-700 mt-1">In repair</p>
        </div>
    </div>
</div>

{{-- Row 2: Category chart + Warranty --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    {{-- Assets by Category --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800 text-sm">Assets by Category</h3>
            <a href="{{ route('assets.index') }}" class="text-xs text-blue-600 hover:underline">View all</a>
        </div>
        @forelse ($byCategory as $row)
        @php $pct = $stats['total'] > 0 ? round(($row['count'] / $stats['total']) * 100) : 0; @endphp
        <div class="mb-3">
            <div class="flex justify-between text-xs mb-1">
                <span class="font-medium text-slate-700">{{ $row['label'] }}</span>
                <span class="text-slate-400">{{ $row['count'] }} ({{ $pct }}%)</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="h-2 rounded-full" style="width:{{ $pct }}%; background:linear-gradient(90deg,#0d2a5e,#3b82f6);"></div>
            </div>
        </div>
        @empty
        <p class="text-sm text-slate-400">No assets recorded yet.</p>
        @endforelse
    </div>

    {{-- Warranty Expiring --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800 text-sm">Warranty Expiring Soon</h3>
            <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">60 days</span>
        </div>
        @forelse ($expiringWarranties as $asset)
        <div class="flex items-center justify-between py-2.5 border-b border-slate-100 last:border-0">
            <div>
                <span class="font-mono text-xs font-bold text-slate-700">{{ $asset->asset_tag }}</span>
                @if ($asset->division)
                <span class="ml-1 text-xs bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded font-bold">{{ $asset->division->code }}</span>
                @endif
                <p class="text-xs text-slate-500 mt-0.5 truncate max-w-48">{{ $asset->name }}</p>
            </div>
            <span class="text-xs font-semibold text-amber-600 flex-shrink-0 ml-2">
                {{ $asset->warranty_expiry->format('M d, Y') }}
            </span>
        </div>
        @empty
        <div class="text-center py-6">
            <svg class="w-8 h-8 text-green-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 13.01 9 10.01"/>
            </svg>
            <p class="text-xs text-slate-400">All warranties are fine!</p>
        </div>
        @endforelse
    </div>

</div>

{{-- Row 3: Open Maintenance Tickets --}}
<div class="grid grid-cols-1 gap-5">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800 text-sm">Open Technical Support Tickets</h3>
            <a href="{{ route('technical_support.index') }}" class="text-xs text-blue-600 hover:underline">View all</a>
        </div>
        @forelse ($openTickets as $ticket)
        <div class="flex items-center gap-3 py-2.5 border-b border-slate-100 last:border-0">
            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-slate-700 truncate">
                    {{ $ticket->division ?: 'No Division' }} — {{ $ticket->reported_by ?: 'No Reporter' }}
                </p>
                <p class="text-xs text-slate-400 truncate">
                    {{ \Illuminate\Support\Str::limit($ticket->issue_problem, 40) }}
                </p>
            </div>
            <span class="text-xs px-2 py-0.5 rounded-full flex-shrink-0 font-semibold
                {{ $ticket->status === 'done' ? 'bg-green-100 text-green-700' : ($ticket->status === 'failed' ? 'bg-red-100 text-red-700' : ($ticket->status === 'for_checking' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700')) }}">
                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
            </span>
        </div>
        @empty
        <p class="text-sm text-slate-400 text-center py-6">No open tickets.</p>
        @endforelse
    </div>

</div>

@endsection