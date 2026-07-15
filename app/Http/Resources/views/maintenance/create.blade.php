@extends('layouts.app')

@section('title', 'Open Maintenance Ticket')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Open Maintenance Ticket</h1>

    <form method="POST" action="{{ route('maintenance.store') }}" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf
        <input type="hidden" name="status" value="open">
        <input type="hidden" name="opened_at" value="{{ now()->format('Y-m-d H:i:s') }}">

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Asset</label>
            <select name="asset_id" class="w-full border rounded px-3 py-2 text-sm">
                <option value="">-- Select asset --</option>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->asset_tag }} — {{ $asset->name }}</option>
                @endforeach
            </select>
            @error('asset_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Issue Description</label>
            <textarea name="issue_description" rows="3" class="w-full border rounded px-3 py-2 text-sm"></textarea>
            @error('issue_description') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Technician (optional)</label>
            <input type="text" name="technician" class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="flex gap-3">
            <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Open Ticket</button>
            <a href="{{ route('maintenance.index') }}" class="px-4 py-2 rounded text-sm border">Cancel</a>
        </div>
    </form>
@endsection