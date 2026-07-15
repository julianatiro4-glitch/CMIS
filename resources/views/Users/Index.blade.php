@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">User Management</h1>
        <a href="{{ route('users.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ New User</a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Joined</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            {{ $user->name }}
                            @if ($user->id === auth()->id())
                                <span class="text-xs text-gray-400">(you)</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs bg-gray-100">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('users.edit', $user) }}" class="text-amber-600 hover:underline">Edit</a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection