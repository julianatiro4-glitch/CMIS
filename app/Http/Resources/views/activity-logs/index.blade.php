@extends('layouts.app')

@section('title', 'Audit Log')
@section('subtitle', 'Full history of every change made to assets')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-slate-100">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-sm">Activity History</h3>
        <span class="text-xs text-slate-400">{{ $logs->total() }} total records</span>
    </div>

    <div class="divide-y divide-slate-100">
        @forelse ($logs as $log)
        @php
        $colors = [
            'created'  => 'bg-green-100 text-green-700',
            'updated'  => 'bg-blue-100 text-blue-700',
            'deleted'  => 'bg-red-100 text-red-700',
            'restored' => 'bg-purple-100 text-purple-700',
        ];
        $icons = ['created'=>'✚','updated'=>'✎','deleted'=>'✕','restored'=>'↩'];
        $badge = $colors[$log->action] ?? 'bg-slate-100 text-slate-600';
        $icon  = $icons[$log->action]  ?? '?';
        @endphp
        <div class="flex items-start gap-4 px-5 py-4 hover:bg-slate-50 transition-colors">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 {{ $badge }}">
                {{ $icon }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-sm font-semibold text-slate-800">{{ $log->description }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $badge }} font-semibold">{{ ucfirst($log->action) }}</span>
                </div>

                @if ($log->action === 'updated' && $log->old_values && $log->new_values)
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach ($log->new_values as $field => $newVal)
                    @php $oldVal = $log->old_values[$field] ?? null; @endphp
                    <span class="text-xs bg-slate-100 rounded px-2 py-1 text-slate-600">
                        <span class="font-semibold">{{ str_replace('_', ' ', $field) }}:</span>
                        <span class="line-through text-red-400">{{ is_bool($oldVal) ? ($oldVal ? 'Yes' : 'No') : ($oldVal ?? '—') }}</span>
                        &rarr;
                        <span class="text-green-600 font-medium">{{ is_bool($newVal) ? ($newVal ? 'Yes' : 'No') : ($newVal ?? '—') }}</span>
                    </span>
                    @endforeach
                </div>
                @endif

                <div class="flex items-center gap-3 mt-1.5">
                    <span class="text-xs text-slate-400">by <span class="font-medium text-slate-600">{{ $log->user?->name ?? 'System' }}</span></span>
                    <span class="text-xs text-slate-400">{{ $log->ip_address }}</span>
                    <span class="text-xs text-slate-400">{{ $log->created_at->format('M d, Y H:i:s') }}</span>
                    <span class="text-xs text-slate-400">({{ $log->created_at->diffForHumans() }})</span>
                </div>
            </div>
        </div>
        @empty
        <div class="px-5 py-12 text-center">
            <p class="text-slate-500 font-medium">No activity yet</p>
            <p class="text-slate-400 text-xs mt-1">Changes to assets will appear here automatically.</p>
        </div>
        @endforelse
    </div>

    @if ($logs->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $logs->links() }}</div>
    @endif
</div>
@endsection