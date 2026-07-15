@extends('layouts.app')

@section('title', 'Divisions / Sections')
@section('subtitle', 'Sub-units under each office location')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-slate-800">Divisions / Sections</h2>
        <p class="text-sm text-slate-500 mt-0.5">Manage sub-units where computers are distributed</p>
    </div>
    <a href="{{ route('divisions.create') }}"
       class="flex items-center gap-2 text-sm font-semibold text-white px-4 py-2 rounded-lg hover:opacity-90"
       style="background:#0d2a5e;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Division
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide border-b border-slate-100">
                    <th class="px-5 py-3">Division / Section</th>
                    <th class="px-5 py-3">Code</th>
                    <th class="px-5 py-3">Location</th>
                    <th class="px-5 py-3">Description</th>
                    <th class="px-5 py-3"># Assets</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($divisions as $division)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3 font-semibold text-slate-800">{{ $division->name }}</td>
                    <td class="px-5 py-3">
                        @if ($division->code)
                            <span class="px-2 py-1 rounded text-xs font-mono font-bold bg-blue-50 text-blue-700">
                                {{ $division->code }}
                            </span>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 2a7 7 0 0 1 7 7c0 5-7 13-7 13S5 14 5 9a7 7 0 0 1 7-7z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                            {{ $division->location->name }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-slate-500 text-xs">{{ $division->description ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                            {{ $division->assets_count }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('divisions.edit', $division) }}"
                               class="text-xs text-amber-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('divisions.destroy', $division) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete {{ addslashes($division->name) }}?');">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                        <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 21h18M3 7v1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7H3l2-4h14l2 4"/>
                        </svg>
                        <p class="text-slate-500 font-medium">No divisions yet</p>
                        <p class="text-slate-400 text-xs mt-1">Add divisions to organize where equipment is distributed</p>
                        <a href="{{ route('divisions.create') }}"
                           class="inline-block mt-3 text-xs font-semibold text-white px-4 py-2 rounded-lg"
                           style="background:#0d2a5e;">+ Add First Division</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($divisions->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $divisions->links() }}</div>
    @endif
</div>
@endsection
