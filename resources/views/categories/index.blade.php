@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Categories</h1>
        <a href="{{ route('categories.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ New Category</a>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2"># Assets</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $category->name }}</td>
                        <td class="px-4 py-2">{{ $category->description ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $category->assets_count }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="text-amber-600 hover:underline">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
@endsection
