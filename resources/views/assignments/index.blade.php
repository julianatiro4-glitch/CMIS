@extends('layouts.app')

@section('title', 'Asset Assignments')
@section('subtitle', 'Manage and track checked-out equipment')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Assignments</h1>
    @if(auth()->user()->canManage())
    <a href="{{ route('assignments.create') }}" class="bg-navy hover:bg-navy-light text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition-colors">+ Checkout Asset</a>
    @endif
</div>

<div class="bg-white rounded-xl shadow border border-slate-100 overflow-x-auto">
    <table class="w-full text-sm text-left text-slate-500">
        <thead class="bg-slate-55 text-xs text-slate-700 uppercase border-b border-slate-100" style="background:#f8fafc;">
            <tr>
                <th class="px-6 py-4">Asset</th>
                <th class="px-6 py-4">Assigned To</th>
                <th class="px-6 py-4">Handled By</th>
                <th class="px-6 py-4">Checkout Date</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Returned Date / Notes</th>
                @if(auth()->user()->canManage())
                <th class="px-6 py-4 text-right">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($assignments as $assignment)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-800">
                            {{ $assignment->asset->name }}
                        </div>
                        <div class="text-xs text-slate-400 font-mono">
                            {{ $assignment->asset->asset_tag }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-700">{{ $assignment->user->name }}</div>
                        <div class="text-xs text-slate-400">{{ $assignment->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-xs">
                        {{ $assignment->assignedBy->name ?? 'System' }}
                    </td>
                    <td class="px-6 py-4 text-xs text-slate-600">
                        {{ $assignment->assigned_at->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($assignment->returned_at)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                Returned
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Active Checkout
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs">
                        @if ($assignment->returned_at)
                            <div class="text-slate-700 font-semibold">
                                {{ $assignment->returned_at->format('M d, Y h:i A') }}
                            </div>
                            @if($assignment->condition_on_return)
                                <div class="text-slate-500 italic mt-0.5">Return Condition: {{ $assignment->condition_on_return }}</div>
                            @endif
                        @else
                            <div class="text-slate-400 italic">
                                {{ $assignment->notes ?? 'No checkout notes' }}
                            </div>
                        @endif
                    </td>
                    @if(auth()->user()->canManage())
                    <td class="px-6 py-4 text-right">
                        @if (!$assignment->returned_at)
                            <form action="{{ route('assignments.check-in', $assignment) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="condition_on_return" placeholder="Condition on return" 
                                       class="px-2 py-1 border border-slate-200 rounded text-xs focus:outline-none focus:ring-1 focus:ring-navy max-w-[150px]" required>
                                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-2.5 py-1 rounded text-xs font-semibold shadow transition-colors">
                                    Check In
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-slate-400 font-semibold">—</span>
                        @endif
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                        No assignments found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $assignments->links() }}
</div>
@endsection
