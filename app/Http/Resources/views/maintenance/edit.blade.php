@extends('layouts.app')

@section('title', 'Update Maintenance Ticket')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Update Maintenance Ticket — {{ $record->asset->asset_tag }}</h1>

    <form method="POST" action="{{ route('maintenance.update', $record) }}" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf
        @method('PUT')
        <input type="hidden" name="asset_id" value="{{ $record->asset_id }}">
        <input type="hidden" name="opened_at" value="{{ $record->opened_at->format('Y-m-d H:i:s') }}">

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Issue Description</label>
            <textarea name="issue_description" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('issue_description', $record->issue_description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Technician</label>
            <input type="text" name="technician" value="{{ old('technician', $record->technician) }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2 text-sm">
                @foreach (\App\Models\MaintenanceRecord::STATUSES as $status)
                    <option value="{{ $status }}" @selected(old('status', $record->status) === $status)>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Cost</label>
            <input type="number" step="0.01" name="cost" value="{{ old('cost', $record->cost) }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Resolution Notes</label>
            <textarea name="resolution_notes" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('resolution_notes', $record->resolution_notes) }}</textarea>
        </div>

        <div class="flex gap-3">
            <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Save</button>
            <a href="{{ route('maintenance.index') }}" class="px-4 py-2 rounded text-sm border">Cancel</a>
        </div>
    </form>
@endsection