<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Computer Inventory System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
    <nav class="bg-slate-800 text-white px-6 py-3 flex items-center gap-6">
        <a href="{{ route('assets.index') }}" class="font-semibold">CMIS</a>
        <a href="{{ route('assets.index') }}" class="text-sm hover:underline">Assets</a>
        <a href="{{ route('categories.index') }}" class="text-sm hover:underline">Categories</a>
        <a href="{{ route('locations.index') }}" class="text-sm hover:underline">Locations</a>
        @auth
            <a href="{{ route('maintenance.index') }}" class="text-sm hover:underline">Maintenance</a>
        @endauth

        <div class="ml-auto flex items-center gap-4">
            @auth
                <span class="text-xs text-gray-300">
                    {{ auth()->user()->name }} ({{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }})
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-sm hover:underline">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm hover:underline">Log In</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-8">
        @if (session('status'))
            <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>