@extends('layouts.app')

@section('title', 'New Category')

@section('content')
    <h1 class="text-2xl font-bold mb-6">New Category</h1>

    <form method="POST" action="{{ route('categories.store') }}" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 text-sm">
            @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('description') }}</textarea>
        </div>
        <div class="flex gap-3">
            <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Save</button>
            <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded text-sm border">Cancel</a>
        </div>
    </form>
@endsection
