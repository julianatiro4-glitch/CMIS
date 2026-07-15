@extends('layouts.app')

@section('title', 'Locations')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Locations</h1>
        <a href="{{ route('locations.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ New Location</a>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Building</th>
                    <th class="px-4 py-2">Floor</th>
                    <th class="px-4 py-2">Room</th>
                    <th class="px-4 py-2"># Assets</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($locations as $location)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $location->name }}</td>
                        <td class="px-4 py-2">{{ $location->building ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $location->floor ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $location->room ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $location->assets_count }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('locations.edit', $location) }}" class="text-amber-600 hover:underline">Edit</a>
                            <form action="{{ route('locations.destroy', $location) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this location?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No locations found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $locations->links() }}</div>
@endsection
