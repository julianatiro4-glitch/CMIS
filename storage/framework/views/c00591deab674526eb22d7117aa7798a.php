<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'CMIS'); ?> — QC PESO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:  { DEFAULT: '#0d2a5e', light: '#1a3a7c', dark: '#091d42' },
                        gold:  { DEFAULT: '#c9960c', light: '#f5c518', pale: '#fef9e7' },
                        crimson: { DEFAULT: '#b91c1c', light: '#dc2626' },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px; border-radius: 8px;
            font-size: 0.8125rem; font-weight: 500;
            color: #93c5fd; transition: all .15s;
        }
        .nav-link:hover { background: rgba(255,255,255,.08); color: #fff; }
        .nav-link.active { background: #1a3a7c; color: #fff; box-shadow: inset 3px 0 0 #f5c518; }
        .stat-card { transition: transform .15s, box-shadow .15s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,.10); }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex">


<aside class="w-60 min-h-screen bg-navy-dark flex flex-col fixed top-0 left-0 z-30 shadow-xl" style="background:#091d42;">

    
    <div class="px-4 py-5 border-b border-white/10">
        <div class="flex items-center gap-3">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="QC PESO Logo"
                 class="w-12 h-12 object-contain rounded-full bg-white p-0.5 shadow flex-shrink-0">
            <div>
                <p class="text-white font-bold text-sm leading-tight">QC PESO</p>
                <p class="text-blue-300 text-xs leading-snug">Computer Management<br>Inventory System</p>
            </div>
        </div>
    </div>

    
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

        <p class="text-xs font-semibold text-blue-400/60 uppercase tracking-widest px-3 pb-2 pt-1">Main</p>

        <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>
        <?php endif; ?>

        <a href="<?php echo e(route('assets.index')); ?>" class="nav-link <?php echo e(request()->routeIs('assets.*') ? 'active' : ''); ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
            </svg>
            Assets
        </a>

        <a href="<?php echo e(route('categories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h10M4 18h14"/>
            </svg>
            Categories
        </a>

        <a href="<?php echo e(route('locations.index')); ?>" class="nav-link <?php echo e(request()->routeIs('locations.*') ? 'active' : ''); ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 2a7 7 0 0 1 7 7c0 5-7 13-7 13S5 14 5 9a7 7 0 0 1 7-7z"/>
                <circle cx="12" cy="9" r="2.5"/>
            </svg>
            Locations
        </a>

        <?php if(auth()->guard()->check()): ?>
        <p class="text-xs font-semibold text-blue-400/60 uppercase tracking-widest px-3 pb-2 pt-4">Operations</p>

        <a href="<?php echo e(route('technical_support.index')); ?>" class="nav-link <?php echo e(request()->routeIs('technical_support.*') ? 'active' : ''); ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
            </svg>
            Technical Support
        </a>

        <a href="<?php echo e(route('activity-logs.index')); ?>" class="nav-link <?php echo e(request()->routeIs('activity-logs.*') ? 'active' : ''); ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
            Audit Log
        </a>


        <?php if(auth()->user()->isAdmin()): ?>
        <p class="text-xs font-semibold text-blue-400/60 uppercase tracking-widest px-3 pb-2 pt-4">Admin</p>

        <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            User Management
        </a>
        <?php endif; ?>
        <?php endif; ?>

    </nav>

    
    <?php if(auth()->guard()->check()): ?>
    <div class="px-3 py-4 border-t border-white/10">
        <div class="flex items-center gap-3 bg-white/5 rounded-lg px-3 py-2.5">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                 style="background:#1a3a7c; border: 2px solid #f5c518;">
                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate"><?php echo e(auth()->user()->name); ?></p>
                <p class="text-blue-300 text-xs truncate"><?php echo e(ucfirst(str_replace('_', ' ', auth()->user()->role))); ?></p>
            </div>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button title="Log out" class="text-blue-300 hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <?php else: ?>
    <div class="px-3 py-4 border-t border-white/10">
        <a href="<?php echo e(route('login')); ?>" class="nav-link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
            </svg>
            Log In
        </a>
    </div>
    <?php endif; ?>

</aside>


<div class="flex-1 ml-60 flex flex-col min-h-screen">

    
    <header class="bg-white border-b border-slate-200 px-8 py-3.5 flex items-center justify-between sticky top-0 z-20 shadow-sm">
        <div>
            <h1 class="text-sm font-bold text-slate-800"><?php echo $__env->yieldContent('title', 'Computer Management Inventory System'); ?></h1>
            <p class="text-xs text-slate-400 mt-0.5"><?php echo $__env->yieldContent('subtitle', 'Quezon City Public Employment Service Office'); ?></p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs font-medium text-slate-600"><?php echo e(now()->format('l')); ?></p>
                <p class="text-xs text-slate-400"><?php echo e(now()->format('F d, Y')); ?></p>
            </div>
            <?php if(auth()->guard()->check()): ?>
            <div class="w-px h-8 bg-slate-200"></div>
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold"
                 style="background:#0d2a5e;">
                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

            </div>
            <?php endif; ?>
        </div>
    </header>

    
    <?php if(session('status') || session('error')): ?>
    <div class="px-8 pt-5">
        <?php if(session('status')): ?>
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 13.01 9 10.01"/>
            </svg>
            <?php echo e(session('status')); ?>

        </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <main class="flex-1 px-8 py-6 pb-12">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <footer class="px-8 py-3 border-t border-slate-200 bg-white">
        <p class="text-xs text-slate-400 text-center">
            © <?php echo e(date('Y')); ?> Quezon City Public Employment Service Office — Computer Management Inventory System
        </p>
    </footer>

</div>
</body>
</html><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/layouts/app.blade.php ENDPATH**/ ?>