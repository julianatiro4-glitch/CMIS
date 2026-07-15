@extends('layouts.app')

@section('title', 'Assign Asset')
@section('subtitle', 'Check out an available asset to a user')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-800">New Assignment</h1>
        <a href="{{ route('assignments.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to list
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-100 p-6">
        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf

            <!-- Asset selection -->
            <div class="mb-4">
                <label for="asset_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Select Asset</label>
                <select name="asset_id" id="asset_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('asset_id') border-red-500 @enderror" required>
                    <option value="" disabled selected>-- Choose an available asset --</option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }} ({{ $asset->asset_tag }}) — {{ ucfirst($asset->condition) }}
                        </option>
                    @endforeach
                </select>
                @error('asset_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                @if($assets->isEmpty())
                    <p class="text-xs text-amber-600 mt-1">⚠️ No available assets found. Return an asset or create a new one first.</p>
                @endif
            </div>

            <!-- User selection -->
            <div class="mb-4">
                <label for="user_id" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Assign To (User)</label>
                <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('user_id') border-red-500 @enderror" required>
                    <option value="" disabled selected>-- Choose a user --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }}) — {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date selection -->
            <div class="mb-4">
                <label for="assigned_at" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Checkout Date & Time</label>
                <input type="datetime-local" name="assigned_at" id="assigned_at" 
                       value="{{ old('assigned_at', now()->format('Y-m-d\TH:i')) }}" 
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('assigned_at') border-red-500 @enderror" required>
                @error('assigned_at')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Checkout Notes / Details</label>
                <textarea name="notes" id="notes" rows="3" placeholder="Condition details, accessories included, purpose..." 
                          class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 justify-end border-t border-slate-100 pt-4">
                <a href="{{ route('assignments.index') }}" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 rounded-lg text-sm font-semibold transition-colors">Cancel</a>
                <button type="submit" class="bg-navy hover:bg-navy-light text-white px-5 py-2 rounded-lg text-sm font-semibold shadow transition-colors" {{ $assets->isEmpty() ? 'disabled' : '' }}>
                    Confirm Checkout
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
