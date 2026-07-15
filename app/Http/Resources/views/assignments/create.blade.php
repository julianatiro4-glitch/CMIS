@extends('layouts.app')

@section('title', 'Check Out Asset')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Check Out Asset</h1>

    @if ($assets->isEmpty())
        <p class="text-sm text-gray-500">No assets are currently available to check out.</p>
    @else
        <form method="POST" action="{{ route('assignments.store') }}" class="bg-white p-6 rounded shadow max-w-lg">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Asset</label>
                <select name="asset_id" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">-- Select an available asset --</option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}">{{ $asset->asset_tag }} — {{ $asset->name }}</option>
                    @endforeach
                </select>
                @error('asset_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Assign To</label>
                <select name="user_id" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">-- Select a user --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Assigned At</label>
                <input type="datetime-local" name="assigned_at" value="{{ now()->format('Y-m-d\TH:i') }}"
                       class="w-full border rounded px-3 py-2 text-sm">
                @error('assigned_at') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Notes</label>
                <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2 text-sm"></textarea>
            </div>

            <div class="flex gap-3">
                <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Check Out</button>
                <a href="{{ route('assignments.index') }}" class="px-4 py-2 rounded text-sm border">Cancel</a>
            </div>
        </form>
    @endif
@endsection