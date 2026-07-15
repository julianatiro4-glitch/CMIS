@extends('layouts.app')

@section('title', 'Open Maintenance Ticket')
@section('subtitle', 'Report an issue and log a repair ticket for an asset')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-800">New Maintenance Ticket</h1>
        <a href="{{ route('maintenance.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to list
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-100 p-6">
        <form action="{{ route('maintenance.store') }}" method="POST">
            @csrf

            <!-- Asset selection -->
            <div class="mb-4">
                <label for="asset_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Select Asset</label>
                <select name="asset_id" id="asset_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('asset_id') border-red-500 @enderror" required>
                    <option value="" disabled selected>-- Choose an asset --</option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }} ({{ $asset->asset_tag }}) — Status: {{ ucfirst(str_replace('_', ' ', $asset->status)) }}
                        </option>
                    @endforeach
                </select>
                @error('asset_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date selection -->
            <div class="mb-4">
                <label for="opened_at" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Opened Date & Time</label>
                <input type="datetime-local" name="opened_at" id="opened_at" 
                       value="{{ old('opened_at', now()->format('Y-m-d\TH:i')) }}" 
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('opened_at') border-red-500 @enderror" required>
                @error('opened_at')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Technician selection -->
            <div class="mb-4">
                <label for="technician" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Assigned Technician</label>
                <input type="text" name="technician" id="technician" placeholder="Technician name / firm" 
                       value="{{ old('technician') }}"
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('technician') border-red-500 @enderror">
                @error('technician')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status selection -->
            <div class="mb-4">
                <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Ticket Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('status') border-red-500 @enderror" required>
                    <option value="open" {{ old('status', 'open') == 'open' ? 'selected' : '' }}>Open (Reported)</option>
                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress (Under Repair)</option>
                    <option value="resolved" {{ old('status') == 'resolved' ? 'selected' : '' }}>Resolved (Completed)</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Issue Description -->
            <div class="mb-6">
                <label for="issue_description" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Issue / Problem Description</label>
                <textarea name="issue_description" id="issue_description" rows="4" placeholder="Detailed description of the issue or malfunction..." 
                          class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('issue_description') border-red-500 @enderror" required>{{ old('issue_description') }}</textarea>
                @error('issue_description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resolution Fields (conditional/optional) -->
            <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 mb-6">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-3">Resolution Details (If Resolved)</h3>
                
                <div class="mb-3">
                    <label for="cost" class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Cost (PHP)</label>
                    <input type="number" name="cost" id="cost" placeholder="0.00" step="0.01" min="0"
                           value="{{ old('cost') }}"
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('cost') border-red-500 @enderror">
                    @error('cost')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="resolved_at" class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Resolved Date & Time</label>
                    <input type="datetime-local" name="resolved_at" id="resolved_at" 
                           value="{{ old('resolved_at') }}" 
                           class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('resolved_at') border-red-500 @enderror">
                    @error('resolved_at')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="resolution_notes" class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Resolution Notes</label>
                    <textarea name="resolution_notes" id="resolution_notes" rows="2" placeholder="Action taken to fix the issue..." 
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('resolution_notes') border-red-500 @enderror">{{ old('resolution_notes') }}</textarea>
                    @error('resolution_notes')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 justify-end border-t border-slate-100 pt-4">
                <a href="{{ route('maintenance.index') }}" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 rounded-lg text-sm font-semibold transition-colors">Cancel</a>
                <button type="submit" class="bg-navy hover:bg-navy-light text-white px-5 py-2 rounded-lg text-sm font-semibold shadow transition-colors">
                    Save Ticket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
