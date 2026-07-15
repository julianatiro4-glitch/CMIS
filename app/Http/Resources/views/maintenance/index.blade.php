@extends('layouts.app')

@section('title', 'Maintenance')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Maintenance Tickets</h1>
        @auth
            @if (auth()->user()->canManage())
                <a href="{{ route('maintenance.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ Open Ticket</a>
            @endif
        @endauth
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Asset</th>
                    <th class="px-4 py-2">Issue</th>
                    <th class="px-4 py-2">Technician</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Opened</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $record->asset->asset_tag }} — {{ $record->asset->name }}</td>
                        <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($record->issue_description, 50) }}</td>
                        <td class="px-4 py-2">{{ $record->technician ?? '—' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs bg-gray-100">
                                {{ ucfirst(str_replace('_', ' ', $record->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $record->opened_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 text-right">
                            @auth
                                @if (auth()->user()->canManage())
                                    <a href="{{ route('maintenance.edit', $record) }}" class="text-amber-600 hover:underline">Update</a>
                                @endif
                            @endauth
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No maintenance tickets yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $records->links() }}</div>
@endsection