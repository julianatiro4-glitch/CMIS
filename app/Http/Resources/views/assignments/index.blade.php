@extends('layouts.app')

@section('title', 'Assignments')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Assignments</h1>
        @auth
            @if (auth()->user()->canManage())
                <a href="{{ route('assignments.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ Check Out Asset</a>
            @endif
        @endauth
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Asset</th>
                    <th class="px-4 py-2">Assigned To</th>
                    <th class="px-4 py-2">Assigned At</th>
                    <th class="px-4 py-2">Returned At</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assignments as $assignment)
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            {{ $assignment->asset->asset_tag }} — {{ $assignment->asset->name }}
                        </td>
                        <td class="px-4 py-2">{{ $assignment->user->name }}</td>
                        <td class="px-4 py-2">{{ $assignment->assigned_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-2">
                            @if ($assignment->returned_at)
                                {{ $assignment->returned_at->format('M d, Y H:i') }}
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">Active</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right">
                            @if (! $assignment->returned_at)
                                @auth
                                    @if (auth()->user()->canManage())
                                        <form action="{{ route('assignments.check-in', $assignment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="text-green-600 hover:underline">Check In</button>
                                        </form>
                                    @endif
                                @endauth
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No assignments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $assignments->links() }}</div>
@endsection