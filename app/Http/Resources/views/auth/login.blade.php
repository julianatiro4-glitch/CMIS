<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — QC PESO CMIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #091d42 0%, #0d2a5e 60%, #1a1a4e 100%);">

    <div class="w-full max-w-4xl flex rounded-2xl overflow-hidden shadow-2xl">

        {{-- LEFT PANEL --}}
        <div class="hidden lg:flex flex-col justify-between w-1/2 p-10 relative" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">

            {{-- Decorative blobs --}}
            <div style="position:absolute;top:-60px;left:-60px;width:200px;height:200px;background:#b91c1c;opacity:.15;border-radius:50%;filter:blur(60px);pointer-events:none;"></div>
            <div style="position:absolute;bottom:-60px;right:-60px;width:200px;height:200px;background:#f5c518;opacity:.15;border-radius:50%;filter:blur(60px);pointer-events:none;"></div>

            {{-- Logo --}}
            <div class="flex items-center gap-3 relative z-10">
                <img src="{{ asset('images/logo.png') }}" alt="QC PESO"
                     class="w-14 h-14 rounded-full bg-white p-0.5 shadow-lg object-contain flex-shrink-0">
                <div>
                    <p class="text-white font-bold text-base leading-tight">QC PESO</p>
                    <p class="text-blue-300 text-xs leading-snug">Quezon City Public Employment<br>Service Office</p>
                </div>
            </div>

            {{-- Heading --}}
            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-white leading-snug mb-3">
                    Computer<br>Management<br>
                    <span style="color:#f5c518;">Inventory System</span>
                </h1>
                <p class="text-blue-200 text-sm leading-relaxed">
                    Monitor, manage, and maintain all office equipment and assets in one centralized platform.
                </p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-3 relative z-10">
                <div class="rounded-xl p-4 text-center" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);">
                    <p class="text-2xl font-bold text-white">3</p>
                    <p class="text-blue-300 text-xs mt-1">User Roles</p>
                </div>
                <div class="rounded-xl p-4 text-center" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);">
                    <p class="text-2xl font-bold text-white">5</p>
                    <p class="text-blue-300 text-xs mt-1">Asset Statuses</p>
                </div>
                <div class="rounded-xl p-4 text-center" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);">
                    <p class="text-2xl font-bold" style="color:#f5c518;">24/7</p>
                    <p class="text-blue-300 text-xs mt-1">Monitoring</p>
                </div>
            </div>

        </div>

        {{-- RIGHT PANEL — Login form --}}
        <div class="flex-1 bg-white flex items-center justify-center p-10">
            <div class="w-full max-w-sm">

                {{-- Mobile logo --}}
                <div class="flex justify-center mb-6 lg:hidden">
                    <img src="{{ asset('images/logo.png') }}" alt="QC PESO"
                         class="w-16 h-16 rounded-full bg-white shadow-lg object-contain border-2 border-slate-100">
                </div>

                <h2 class="text-xl font-bold text-slate-800 mb-1">Welcome back</h2>
                <p class="text-slate-400 text-sm mb-6">Sign in to your CMIS account</p>

                {{-- Alerts --}}
                @if (session('status'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                @error('email')
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                        {{ $message }}
                    </div>
                @enderror

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                            Email Address
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" autofocus
                                   placeholder="you@example.com"
                                   class="w-full border border-slate-200 rounded-lg pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <input type="password" name="password" id="password"
                                   placeholder="••••••••"
                                   class="w-full border border-slate-200 rounded-lg pl-10 pr-16 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <button type="button" id="togglePassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                Show
                            </button>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center gap-2 mb-5">
                        <input type="checkbox" name="remember" id="remember"
                               class="w-4 h-4 rounded border-slate-300">
                        <label for="remember" class="text-sm text-slate-500 select-none cursor-pointer">Remember me</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full text-white font-semibold py-2.5 rounded-lg text-sm transition-all hover:opacity-90 active:scale-95 shadow-md"
                            style="background: linear-gradient(135deg, #091d42, #1a3a7c);">
                        Sign In →
                    </button>
                </form>

                {{-- Demo accounts --}}
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <p class="text-xs font-semibold text-slate-400 mb-2">Demo accounts</p>
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center text-xs bg-slate-50 rounded-lg px-3 py-2">
                            <span class="text-slate-600">admin@example.com</span>
                            <span class="font-semibold px-2 py-0.5 rounded-full text-xs" style="background:#fef9e7;color:#92400e;">Admin</span>
                        </div>
                        <div class="flex justify-between items-center text-xs bg-slate-50 rounded-lg px-3 py-2">
                            <span class="text-slate-600">staff@example.com</span>
                            <span class="font-semibold px-2 py-0.5 rounded-full text-xs bg-blue-50 text-blue-700">IT Staff</span>
                        </div>
                        <div class="flex justify-between items-center text-xs bg-slate-50 rounded-lg px-3 py-2">
                            <span class="text-slate-600">viewer@example.com</span>
                            <span class="font-semibold px-2 py-0.5 rounded-full text-xs bg-slate-100 text-slate-500">Viewer</span>
                        </div>
                        <p class="text-xs text-slate-400 text-center pt-1">
                            All passwords: <code class="bg-slate-100 px-1.5 py-0.5 rounded font-mono">password</code>
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        var btn = document.getElementById('togglePassword');
        var pwd = document.getElementById('password');
        btn.addEventListener('click', function() {
            var isHidden = pwd.type === 'password';
            pwd.type = isHidden ? 'text' : 'password';
            btn.textContent = isHidden ? 'Hide' : 'Show';
        });
    </script>

</body>
</html>