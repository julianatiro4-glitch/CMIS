@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit User</h1>

    <form method="POST" action="{{ route('users.update', $user) }}" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf
        @method('PUT')
        @include('users._form')
        <div class="flex gap-3 mt-4">
            <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Save</button>
            <a href="{{ route('users.index') }}" class="px-4 py-2 rounded text-sm border">Cancel</a>
        </div>
    </form>
@endsection