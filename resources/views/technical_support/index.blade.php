@extends('layouts.app')

@section('title', 'Technical Support Logs')
@section('subtitle', 'Track and manage technical support tickets')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Technical Support Records</h1>
    @if(auth()->user()->canManage())
    <a href="{{ route('technical_support.create') }}" class="bg-navy hover:bg-navy-light text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition-colors">+ Open Technical Support Ticket</a>
    @endif
</div>

<div class="bg-white rounded-xl shadow border border-slate-100 overflow-x-auto">
    <table class="w-full text-sm text-left text-slate-500">
        <thead class="bg-slate-55 text-xs text-slate-700 uppercase border-b border-slate-100" style="background:#f8fafc;">
            <tr>
                <th class="px-6 py-4">Date</th>
                <th class="px-6 py-4">Division</th>
                <th class="px-6 py-4">Reported By</th>
                <th class="px-6 py-4">Issue / Problem</th>
                <th class="px-6 py-4">Action Taken</th>
                <th class="px-6 py-4">Handled By</th>
                <th class="px-6 py-4">Status</th>
                @if(auth()->user()->canManage())
                <th class="px-6 py-4 text-right">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($records as $record)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-xs text-slate-600">
                        {{ $record->date->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-6 py-4 text-slate-700 font-medium">
                        {{ $record->division ?? '—' }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800">
                        {{ $record->reported_by ?? '—' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-slate-700 font-medium max-w-xs truncate" title="{{ $record->issue_problem }}">
                            {{ $record->issue_problem }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-slate-700 font-medium max-w-xs truncate" title="{{ $record->action_taken }}">
                            {{ $record->action_taken ?? '—' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                        {{ $record->handled_by ?? 'Unassigned' }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($record->status === 'done')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Done
                            </span>
                        @elseif ($record->status === 'in_progress')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                In Progress
                            </span>
                        @elseif ($record->status === 'for_checking')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                For Checking
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Failed
                            </span>
                        @endif
                    </td>
                    @if(auth()->user()->canManage())
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('technical_support.edit', $record) }}" class="inline-flex items-center text-xs font-bold text-amber-600 hover:text-amber-700 hover:underline">
                                Edit
                            </a>
                            <form action="{{ route('technical_support.destroy', $record) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center text-xs font-bold text-red-500 hover:text-red-700 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-slate-400">
                        No technical support tickets found.
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
