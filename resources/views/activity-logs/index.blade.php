@extends('layouts.app')

@section('title', 'System Audit Log')
@section('subtitle', 'History of operations, creations, edits, and deletions')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Audit Logs</h1>
</div>

<div class="bg-white rounded-xl shadow border border-slate-100 overflow-x-auto">
    <table class="w-full text-sm text-left text-slate-500">
        <thead class="bg-slate-55 text-xs text-slate-700 uppercase border-b border-slate-100" style="background:#f8fafc;">
            <tr>
                <th class="px-6 py-4">User / Operator</th>
                <th class="px-6 py-4">Action</th>
                <th class="px-6 py-4">Resource</th>
                <th class="px-6 py-4">Description</th>
                <th class="px-6 py-4">IP Address</th>
                <th class="px-6 py-4">Date & Time</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($logs as $log)
                <tr class="hover:bg-slate-50 transition-colors">
                    <!-- User -->
                    <td class="px-6 py-4">
                        @if ($log->user)
                            <div class="font-semibold text-slate-800">{{ $log->user->name }}</div>
                            <div class="text-xs text-slate-400">{{ ucfirst($log->user->role) }}</div>
                        @else
                            <div class="font-semibold text-slate-400">System / Guest</div>
                        @endif
                    </td>

                    <!-- Action Badge -->
                    <td class="px-6 py-4">
                        @if ($log->action === 'created')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                Created
                            </span>
                        @elseif ($log->action === 'updated')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                Updated
                            </span>
                        @elseif ($log->action === 'deleted')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                Deleted
                            </span>
                        @elseif ($log->action === 'restored')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                                Restored
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                {{ ucfirst($log->action) }}
                            </span>
                        @endif
                    </td>

                    <!-- Resource Class & Name/Tag -->
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded font-semibold text-xs text-slate-600 uppercase tracking-wide">
                            {{ class_basename($log->model_type) }}
                        </span>
                        <div class="text-xs font-bold font-mono text-slate-700 mt-1.5">
                            ID: {{ $log->model_id }} ({{ $log->model_label }})
                        </div>
                    </td>

                    <!-- Description & Inspections -->
                    <td class="px-6 py-4 max-w-md">
                        <div class="text-slate-800 font-medium">
                            {{ $log->description }}
                        </div>
                        
                        <!-- Value Inspections -->
                        @if (!empty($log->old_values) || !empty($log->new_values))
                            <details class="mt-2 group">
                                <summary class="text-xs text-blue-600 hover:text-blue-700 font-semibold cursor-pointer select-none outline-none">
                                    Show detail changes
                                </summary>
                                <div class="mt-2 text-xs bg-slate-50 border border-slate-200 rounded-lg p-3 grid grid-cols-1 md:grid-cols-2 gap-4 font-mono overflow-auto max-h-60 shadow-inner">
                                    <div>
                                        <div class="font-bold text-[10px] text-slate-400 uppercase tracking-wider mb-1 pb-1 border-b border-slate-200">Before Change</div>
                                        @if (!empty($log->old_values))
                                            <table class="w-full text-left">
                                                <tbody>
                                                    @foreach ($log->old_values as $key => $val)
                                                        <tr>
                                                            <td class="pr-2 py-0.5 font-bold text-slate-500">{{ $key }}:</td>
                                                            <td class="py-0.5 text-slate-700 break-all">{{ is_array($val) ? json_encode($val) : (is_bool($val) ? ($val ? 'true' : 'false') : $val) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <span class="text-slate-400 italic">None / Created New</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-[10px] text-slate-400 uppercase tracking-wider mb-1 pb-1 border-b border-slate-200">After Change</div>
                                        @if (!empty($log->new_values))
                                            <table class="w-full text-left">
                                                <tbody>
                                                    @foreach ($log->new_values as $key => $val)
                                                        <tr>
                                                            <td class="pr-2 py-0.5 font-bold text-slate-500">{{ $key }}:</td>
                                                            <td class="py-0.5 text-slate-700 break-all">{{ is_array($val) ? json_encode($val) : (is_bool($val) ? ($val ? 'true' : 'false') : $val) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <span class="text-slate-400 italic">None / Deleted</span>
                                        @endif
                                    </div>
                                </div>
                            </details>
                        @endif
                    </td>

                    <!-- IP Address -->
                    <td class="px-6 py-4 text-xs font-mono text-slate-600">
                        {{ $log->ip_address ?? '—' }}
                    </td>

                    <!-- Created At -->
                    <td class="px-6 py-4 text-xs text-slate-600 whitespace-nowrap">
                        <div class="font-semibold">{{ $log->created_at->format('M d, Y h:i A') }}</div>
                        <div class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                        No audit logs recorded yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div>
@endsection
