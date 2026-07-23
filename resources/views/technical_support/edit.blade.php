@extends('layouts.app')

@section('title', 'Edit Technical Support Ticket')
@section('subtitle', 'Update technical support ticket information')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-800">Edit Technical Support Ticket</h1>
        <a href="{{ route('technical_support.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to list
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-100 p-6">
        <form action="{{ route('technical_support.update', $record) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Date selection -->
            <div class="mb-4">
                <label for="date" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Date & Time</label>
                <input type="datetime-local" name="date" id="date" 
                       value="{{ old('date', $record->date->format('Y-m-d\TH:i')) }}" 
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('date') border-red-500 @enderror" required>
                @error('date')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Division -->
            <div class="mb-4">
                <label for="division" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Division</label>
                <select name="division" id="division" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('division') border-red-500 @enderror">
                    <option value="">-- Select Division --</option>
                    @foreach(['PED', 'LMISD', 'Admin', 'SPD', 'OPM', 'LRSD', 'DOC', 'MSD'] as $div)
                        <option value="{{ $div }}" {{ old('division', $record->division) == $div ? 'selected' : '' }}>{{ $div }}</option>
                    @endforeach
                </select>
                @error('division')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reported By -->
            <div class="mb-4">
                <label for="reported_by" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Reported By</label>
                <input type="text" name="reported_by" id="reported_by" placeholder="e.g. Mam Ara" 
                       value="{{ old('reported_by', $record->reported_by) }}"
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('reported_by') border-red-500 @enderror">
                @error('reported_by')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Handled By -->
            <div class="mb-4">
                <label for="handled_by" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Handled By</label>
                <input type="text" name="handled_by" id="handled_by" placeholder="Technician name" 
                       value="{{ old('handled_by', $record->handled_by) }}"
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('handled_by') border-red-500 @enderror">
                @error('handled_by')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status selection -->
            <div class="mb-4">
                <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Ticket Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('status') border-red-500 @enderror" required>
                    <option value="in_progress" {{ old('status', $record->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="for_checking" {{ old('status', $record->status) == 'for_checking' ? 'selected' : '' }}>For Checking</option>
                    <option value="failed" {{ old('status', $record->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="done" {{ old('status', $record->status) == 'done' ? 'selected' : '' }}>Done</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Issue Description -->
            <div class="mb-6">
                <label for="issue_problem" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Issue / Problem</label>
                <textarea name="issue_problem" id="issue_problem" rows="4" placeholder="Detailed description of the issue..." 
                          class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('issue_problem') border-red-500 @enderror" required>{{ old('issue_problem', $record->issue_problem) }}</textarea>
                @error('issue_problem')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Resolution Fields (conditional/optional) -->
            <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 mb-6">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-3">Resolution Details</h3>

                <div>
                    <label for="action_taken" class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Action Taken</label>
                    <textarea name="action_taken" id="action_taken" rows="3" placeholder="Action taken to fix the issue..." 
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('action_taken') border-red-500 @enderror">{{ old('action_taken', $record->action_taken) }}</textarea>
                    @error('action_taken')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 justify-end border-t border-slate-100 pt-4">
                <a href="{{ route('technical_support.index') }}" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 rounded-lg text-sm font-semibold transition-colors">Cancel</a>
                <button type="submit" class="bg-navy hover:bg-navy-light text-white px-5 py-2 rounded-lg text-sm font-semibold shadow transition-colors">
                    Update Ticket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
