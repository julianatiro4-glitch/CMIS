@extends('layouts.app')

@section('title', 'Maintenance Logs')
@section('subtitle', 'Track and manage asset repairs and service tickets')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Maintenance Records</h1>
    @if(auth()->user()->canManage())
    <a href="{{ route('maintenance.create') }}" class="bg-navy hover:bg-navy-light text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition-colors">+ Open Maintenance Ticket</a>
    @endif
</div>

<div class="bg-white rounded-xl shadow border border-slate-100 overflow-x-auto">
    <table class="w-full text-sm text-left text-slate-500">
        <thead class="bg-slate-55 text-xs text-slate-700 uppercase border-b border-slate-100" style="background:#f8fafc;">
            <tr>
                <th class="px-6 py-4">Asset</th>
                <th class="px-6 py-4">Issue Description</th>
                <th class="px-6 py-4">Technician</th>
                <th class="px-6 py-4">Opened Date</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Cost</th>
                <th class="px-6 py-4">Resolved Date / Notes</th>
                @if(auth()->user()->canManage())
                <th class="px-6 py-4 text-right">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($records as $record)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-800">
                            {{ $record->asset->name }}
                        </div>
                        <div class="text-xs text-slate-400 font-mono">
                            {{ $record->asset->asset_tag }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-slate-700 font-medium max-w-xs truncate" title="{{ $record->issue_description }}">
                            {{ $record->issue_description }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                        {{ $record->technician ?? 'Unassigned' }}
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-600">
                        {{ $record->opened_at->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($record->status === 'resolved')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Resolved
                            </span>
                        @elseif ($record->status === 'in_progress')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                In Progress
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Open
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-800 font-bold">
                        @if ($record->cost !== null)
                            &#8369;{{ number_format($record->cost, 2) }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs">
                        @if ($record->resolved_at)
                            <div class="text-slate-700 font-semibold">
                                {{ $record->resolved_at->format('M d, Y h:i A') }}
                            </div>
                            @if($record->resolution_notes)
                                <div class="text-slate-500 italic mt-0.5" title="{{ $record->resolution_notes }}">
                                    Note: {{ Str::limit($record->resolution_notes, 40) }}
                                </div>
                            @endif
                        @else
                            <span class="text-slate-400 italic">Pending resolution</span>
                        @endif
                    </td>
                    @if(auth()->user()->canManage())
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('maintenance.edit', $record) }}" class="inline-flex items-center text-xs font-bold text-amber-600 hover:text-amber-700 hover:underline">
                            Edit/Update
                        </a>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-slate-400">
                        No maintenance tickets found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $records->links() }}
</div>
@endsection
