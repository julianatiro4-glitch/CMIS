@extends('layouts.app')

@section('title', 'Trash')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Trash</h1>
        <a href="{{ route('assets.index') }}" class="border px-4 py-2 rounded text-sm">Back to Assets</a>
    </div>

    <p class="text-sm text-gray-500 mb-4">
        Retired/deleted assets are kept here. Restore them to bring them back, or permanently delete
        if you're sure they're gone for good.
    </p>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Tag</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Deleted At</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assets as $asset)
                    <tr class="border-t">
                        <td class="px-4 py-2 font-mono">{{ $asset->asset_tag }}</td>
                        <td class="px-4 py-2">{{ $asset->name }}</td>
                        <td class="px-4 py-2">{{ $asset->category->name }}</td>
                        <td class="px-4 py-2">{{ $asset->deleted_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <form action="{{ route('assets.restore', $asset->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline">Restore</button>
                            </form>
                            <form action="{{ route('assets.force-delete', $asset->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Permanently delete this asset? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete Forever</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Trash is empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $assets->links() }}
    </div>
@endsection