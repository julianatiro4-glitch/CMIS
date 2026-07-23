@extends('layouts.app')

@section('title', 'Assets')
@section('subtitle', 'All registered office computers and equipment')

@section('content')

<form id="bulk-delete-form" action="{{ route('assets.bulk-destroy') }}" method="POST" class="hidden" onsubmit="return confirm('Are you sure you want to delete the selected assets simultaneously?');">
    @csrf
</form>

{{-- Stat cards --}}
<div class="grid grid-cols-1 gap-4 mb-6">
    <div class="bg-white rounded-xl px-5 py-4 shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        </div>
        <div><p class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</p><p class="text-xs text-slate-400">Total Assets</p></div>
    </div>
</div>

{{-- Table card --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100">

    {{-- Toolbar --}}
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
        <h3 class="font-bold text-slate-800 text-sm">Equipment List</h3>
        <div class="flex items-center gap-2">
            @if(auth()->user()->canManage())
            <button type="submit" id="bulk-delete-btn" form="bulk-delete-form" class="hidden items-center gap-1.5 text-xs font-semibold text-white bg-red-600 px-3 py-1.5 rounded-lg hover:bg-red-700 transition-colors shadow">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                Delete Selected (<span id="bulk-count">0</span>)
            </button>
            @endif
            <a href="{{ route('assets.trash') }}" class="flex items-center gap-1.5 text-xs font-medium text-slate-600 border border-slate-200 px-3 py-1.5 rounded-lg hover:bg-slate-50 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg> Trash
            </a>
            <a href="{{ route('assets.export', request()->query()) }}" class="flex items-center gap-1.5 text-xs font-medium text-slate-600 border border-slate-200 px-3 py-1.5 rounded-lg hover:bg-slate-50 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Export CSV
            </a>
            @if(auth()->user()->canManage())
            <a href="{{ route('assets.create') }}" class="flex items-center gap-1.5 text-xs font-semibold text-white px-4 py-1.5 rounded-lg hover:opacity-90" style="background:#0d2a5e;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> New Asset
            </a>
            @endif
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" class="flex flex-wrap items-center gap-3 px-5 py-3 bg-slate-50 border-b border-slate-100">
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Search tag, name, user..."
                   class="border border-slate-200 rounded-lg pl-9 pr-4 py-2 text-xs w-56 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
        </div>
        <select name="division_id" class="border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
            <option value="">All Divisions</option>
            @foreach ($divisions as $d)
                <option value="{{ $d->id }}" @selected(request('division_id') == $d->id)>
                    {{ $d->code ? "[{$d->code}] " : '' }}{{ $d->name }}
                </option>
            @endforeach
        </select>
        <button class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50">Filter</button>
        @if(request()->hasAny(['q','division_id']))
            <a href="{{ route('assets.index') }}" class="text-xs text-red-500 hover:underline">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide border-b border-slate-100">
                    @if(auth()->user()->canManage())
                    <th class="px-4 py-3 w-10"><input type="checkbox" id="select-all" class="rounded border-slate-300 text-navy focus:ring-navy w-4 h-4 cursor-pointer"></th>
                    @endif
                    <th class="px-4 py-3">Asset</th>
                    <th class="px-4 py-3">Division</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">CPU</th>
                    <th class="px-4 py-3">RAM</th>
                    <th class="px-4 py-3">Storage</th>
                    <th class="px-4 py-3">OS</th>
                    <th class="px-4 py-3">Utilized By</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($assets as $asset)
                @php
                $conditionColors = ['good'=>'bg-green-100 text-green-700','fair'=>'bg-yellow-100 text-yellow-700','for_repair'=>'bg-orange-100 text-orange-700','unserviceable'=>'bg-red-100 text-red-700'];
                @endphp
                <tr class="hover:bg-slate-50 transition-colors">
                    @if(auth()->user()->canManage())
                    <td class="px-4 py-3">
                        <input type="checkbox" name="ids[]" value="{{ $asset->id }}" form="bulk-delete-form" class="asset-checkbox rounded border-slate-300 text-navy focus:ring-navy w-4 h-4 cursor-pointer">
                    </td>
                    @endif
                    <td class="px-4 py-3">
                        <p class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded inline-block">{{ $asset->asset_tag }}</p>
                        <p class="text-xs font-medium text-slate-800 mt-0.5">{{ $asset->name }}</p>
                        <p class="text-xs text-slate-400">{{ $asset->model ?: '' }}</p>
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-600">
                        @if ($asset->division)
                            @if ($asset->division->code)
                                <span class="font-mono font-bold text-blue-700 bg-blue-50 px-1.5 py-0.5 rounded text-xs">{{ $asset->division->code }}</span><br>
                            @endif
                            <span class="text-slate-500">{{ $asset->division->name }}</span>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-xs">
                        <span class="px-2 py-0.5 rounded-full font-bold {{ $conditionColors[$asset->condition ?? 'good'] ?? 'bg-slate-100 text-slate-500' }}">
                            {{ ucfirst(str_replace('_', ' ', $asset->condition ?? 'good')) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-600 max-w-32">
                        <span title="{{ $asset->cpu }}">{{ $asset->cpu ? \Illuminate\Support\Str::limit($asset->cpu, 20) : '—' }}</span>
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-600 whitespace-nowrap">{{ $asset->ram_total ?: '—' }}</td>
                    <td class="px-4 py-3 text-xs text-slate-600 whitespace-nowrap">{{ $asset->storage_capacity ?: '—' }}</td>
                    <td class="px-4 py-3 text-xs text-slate-600 max-w-28">
                        <span title="{{ $asset->operating_system }}">{{ $asset->operating_system ? \Illuminate\Support\Str::limit($asset->operating_system, 15) : '—' }}</span>
                    </td>
                    <td class="px-4 py-3 text-xs text-slate-600">{{ $asset->utilized_by ?: '—' }}</td>
                    <td class="px-4 py-3 text-right">
    <div class="flex items-center justify-end gap-2">
        <a href="{{ route('assets.show', $asset) }}"
           title="View"
           class="w-7 h-7 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </a>
        <a href="{{ route('assets.edit', $asset) }}"
           title="Edit"
           class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
        </a>
        @if(auth()->user()->canManage())
        <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="inline"
              onsubmit="return confirm('Delete {{ addslashes($asset->asset_tag) }} — {{ addslashes($asset->name) }}?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    title="Delete {{ $asset->asset_tag }}"
                    class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4h6v2"/>
                </svg>
            </button>
        </form>
        @endif
    </div>
</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->canManage() ? '10' : '9' }}" class="px-5 py-14 text-center">
                        <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                        <p class="text-slate-500 font-medium">No assets found</p>
                        @if(auth()->user()->canManage())
                        <a href="{{ route('assets.create') }}" class="inline-block mt-3 text-xs font-semibold text-white px-4 py-2 rounded-lg" style="background:#0d2a5e;">+ Add First Asset</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($assets->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $assets->links() }}</div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const assetCheckboxes = document.querySelectorAll('.asset-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const bulkCount = document.getElementById('bulk-count');

    function updateBulkButton() {
        const checkedCount = document.querySelectorAll('.asset-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkDeleteBtn.classList.remove('hidden');
            bulkDeleteBtn.classList.add('inline-flex');
            bulkCount.textContent = checkedCount;
        } else {
            bulkDeleteBtn.classList.add('hidden');
            bulkDeleteBtn.classList.remove('inline-flex');
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            assetCheckboxes.forEach(cb => {
                cb.checked = selectAllCheckbox.checked;
            });
            updateBulkButton();
        });
    }

    assetCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if (!cb.checked) {
                selectAllCheckbox.checked = false;
            } else {
                const allChecked = Array.from(assetCheckboxes).every(c => c.checked);
                selectAllCheckbox.checked = allChecked;
            }
            updateBulkButton();
        });
    });
});
</script>
@endsection