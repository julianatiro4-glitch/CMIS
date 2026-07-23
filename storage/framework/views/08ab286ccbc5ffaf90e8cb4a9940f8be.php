<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('subtitle', 'Overview of all office equipment and assets'); ?>

<?php $__env->startSection('content'); ?>


<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <div>
        <h2 class="text-lg font-bold text-slate-800">
            Good <?php echo e(now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening')); ?>,
            <?php echo e(explode(' ', auth()->user()->name)[0]); ?>

        </h2>
        <p class="text-sm text-slate-400 mt-0.5"><?php echo e(now()->format('l, F d, Y')); ?></p>
    </div>
    <?php if(auth()->user()->isAdmin()): ?>
    <a href="<?php echo e(route('users.index')); ?>"
       class="flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition-colors text-slate-700 self-start">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Manage Users
    </a>
    <?php endif; ?>
</div>


<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-slate-800"><?php echo e($stats['total']); ?></p>
        <p class="text-xs text-slate-400 mt-0.5">Total Assets</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 13.01 9 10.01"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-green-600"><?php echo e($stats['good']); ?></p>
        <p class="text-xs text-slate-400 mt-0.5">Good</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-yellow-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['fair']); ?></p>
        <p class="text-xs text-slate-400 mt-0.5">Fair</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-orange-600"><?php echo e($stats['for_repair']); ?></p>
        <p class="text-xs text-slate-400 mt-0.5">For Repair</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
        <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center mb-3">
            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['unserviceable']); ?></p>
        <p class="text-xs text-slate-400 mt-0.5">Unserviceable</p>
    </div>
</div>


<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Needs attention</h3>
            <p class="text-xs text-slate-400 mt-0.5">A quick snapshot of items that need follow-up</p>
        </div>
        <span class="text-xs bg-red-50 text-red-700 px-2.5 py-1 rounded-full font-semibold">Priority view</span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="rounded-lg border border-red-100 bg-red-50 p-3">
            <p class="text-2xl font-bold text-red-700"><?php echo e($attentionSummary['open_tickets']); ?></p>
            <p class="text-xs text-red-600 mt-1">Open tickets</p>
        </div>
        <div class="rounded-lg border border-amber-100 bg-amber-50 p-3">
            <p class="text-2xl font-bold text-amber-700"><?php echo e($attentionSummary['warranty_alerts']); ?></p>
            <p class="text-xs text-amber-700 mt-1">Warranty alerts</p>
        </div>
        <div class="rounded-lg border border-blue-100 bg-blue-50 p-3">
            <p class="text-2xl font-bold text-blue-700"><?php echo e($attentionSummary['in_repair']); ?></p>
            <p class="text-xs text-blue-700 mt-1">In repair</p>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800 text-sm">Assets by Category</h3>
            <a href="<?php echo e(route('assets.index')); ?>" class="text-xs text-blue-600 hover:underline">View all</a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $byCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $pct = $stats['total'] > 0 ? round(($row['count'] / $stats['total']) * 100) : 0; ?>
        <div class="mb-3">
            <div class="flex justify-between text-xs mb-1">
                <span class="font-medium text-slate-700"><?php echo e($row['label']); ?></span>
                <span class="text-slate-400"><?php echo e($row['count']); ?> (<?php echo e($pct); ?>%)</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="h-2 rounded-full" style="width:<?php echo e($pct); ?>%; background:linear-gradient(90deg,#0d2a5e,#3b82f6);"></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-sm text-slate-400">No assets recorded yet.</p>
        <?php endif; ?>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800 text-sm">Warranty Expiring Soon</h3>
            <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">60 days</span>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $expiringWarranties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-center justify-between py-2.5 border-b border-slate-100 last:border-0">
            <div>
                <span class="font-mono text-xs font-bold text-slate-700"><?php echo e($asset->asset_tag); ?></span>
                <?php if($asset->division): ?>
                <span class="ml-1 text-xs bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded font-bold"><?php echo e($asset->division->code); ?></span>
                <?php endif; ?>
                <p class="text-xs text-slate-500 mt-0.5 truncate max-w-48"><?php echo e($asset->name); ?></p>
            </div>
            <span class="text-xs font-semibold text-amber-600 flex-shrink-0 ml-2">
                <?php echo e($asset->warranty_expiry->format('M d, Y')); ?>

            </span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-6">
            <svg class="w-8 h-8 text-green-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 13.01 9 10.01"/>
            </svg>
            <p class="text-xs text-slate-400">All warranties are fine!</p>
        </div>
        <?php endif; ?>
    </div>

</div>


<div class="grid grid-cols-1 gap-5">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800 text-sm">Open Technical Support Tickets</h3>
            <a href="<?php echo e(route('technical_support.index')); ?>" class="text-xs text-blue-600 hover:underline">View all</a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $openTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-center gap-3 py-2.5 border-b border-slate-100 last:border-0">
            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-slate-700 truncate">
                    <?php echo e($ticket->division ?: 'No Division'); ?> — <?php echo e($ticket->reported_by ?: 'No Reporter'); ?>

                </p>
                <p class="text-xs text-slate-400 truncate">
                    <?php echo e(\Illuminate\Support\Str::limit($ticket->issue_problem, 40)); ?>

                </p>
            </div>
            <span class="text-xs px-2 py-0.5 rounded-full flex-shrink-0 font-semibold
                <?php echo e($ticket->status === 'done' ? 'bg-green-100 text-green-700' : ($ticket->status === 'failed' ? 'bg-red-100 text-red-700' : ($ticket->status === 'for_checking' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'))); ?>">
                <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status))); ?>

            </span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-sm text-slate-400 text-center py-6">No open tickets.</p>
        <?php endif; ?>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/dashboard/index.blade.php ENDPATH**/ ?>