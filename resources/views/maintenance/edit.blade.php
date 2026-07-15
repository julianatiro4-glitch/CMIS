@extends('layouts.app')

@section('title', 'Update Maintenance Ticket')
@section('subtitle', 'Manage progress and resolution for service ticket #' . $record->id)

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-800">Update Ticket #{{ $record->id }}</h1>
        <a href="{{ route('maintenance.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to list
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-100 p-6">
        <form action="{{ route('maintenance.update', $record) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Selected Asset -->
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Asset</label>
                <div class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 font-semibold">
                    {{ $record->asset->name }} ({{ $record->asset->asset_tag }})
                </div>
                <!-- Hidden input for asset_id validation -->
                <input type="hidden" name="asset_id" value="{{ $record->asset_id }}">
            </div>

            <!-- Date selection -->
            <div class="mb-4">
                <label for="opened_at" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Opened Date & Time</label>
                <input type="datetime-local" name="opened_at" id="opened_at" 
                       value="{{ old('opened_at', $record->opened_at ? $record->opened_at->format('Y-m-d\TH:i') : '') }}" 
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('opened_at') border-red-500 @enderror" required>
                @error('opened_at')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Technician selection -->
            <div class="mb-4">
                <label for="technician" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Assigned Technician</label>
                <input type="text" name="technician" id="technician" placeholder="Technician name / firm" 
                       value="{{ old('technician', $record->technician) }}"
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('technician') border-red-500 @enderror">
                @error('technician')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status selection -->
            <div class="mb-4">
                <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Ticket Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('status') border-red-500 @enderror" required>
                    <option value="open" {{ old('status', $record->status) == 'open' ? 'selected' : '' }}>Open (Reported)</option>
                    <option value="in_progress" {{ old('status', $record->status) == 'in_progress' ? 'selected' : '' }}>In Progress (Under Repair)</option>
                    <option value="resolved" {{ old('status', $record->status) == 'resolved' ? 'selected' : '' }}>Resolved (Completed)</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Issue Description -->
            <div class="mb-6">
                <label for="issue_description" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Issue / Problem Description</label>
                <textarea name="issue_description" id="issue_description" rows="4" placeholder="Detailed description of the issue..." 
                          class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('issue_description') border-red-500 @enderror" required>{{ old('issue_description', $record->issue_description) }}</textarea>
                @error('issue_description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resolution Fields -->
            <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 mb-6">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-3">Resolution Details</h3>
                
                <div class="mb-3">
                    <label for="cost" class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Cost (PHP)</label>
                    <input type="number" name="cost" id="cost" placeholder="0.00" step="0.01" min="0"
                           value="{{ old('cost', $record->cost) }}"
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('cost') border-red-500 @enderror">
                    @error('cost')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="resolved_at" class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Resolved Date & Time</label>
                    <input type="datetime-local" name="resolved_at" id="resolved_at" 
                           value="{{ old('resolved_at', $record->resolved_at ? $record->resolved_at->format('Y-m-d\TH:i') : '') }}" 
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('resolved_at') border-red-500 @enderror">
                    @error('resolved_at')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="resolution_notes" class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Resolution Notes</label>
                    <textarea name="resolution_notes" id="resolution_notes" rows="2" placeholder="Action taken to resolve..." 
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('resolution_notes') border-red-500 @enderror">{{ old('resolution_notes', $record->resolution_notes) }}</textarea>
                    @error('resolution_notes')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 justify-end border-t border-slate-100 pt-4">
                <a href="{{ route('maintenance.index') }}" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 rounded-lg text-sm font-semibold transition-colors">Cancel</a>
                <button type="submit" class="bg-navy hover:bg-navy-light text-white px-5 py-2 rounded-lg text-sm font-semibold shadow transition-colors">
                    Update Ticket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
