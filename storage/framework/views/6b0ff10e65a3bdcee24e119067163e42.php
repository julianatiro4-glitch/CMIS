<?php $__env->startSection('title', 'System Audit Log'); ?>
<?php $__env->startSection('subtitle', 'History of operations, creations, edits, and deletions'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Audit Logs</h1>
</div>

<div class="bg-white rounded-xl shadow border border-slate-100 overflow-x-auto">
    <table class="w-full text-sm text-left text-slate-500">
        <thead class="bg-slate-55 text-xs text-slate-700 uppercase border-b border-slate-100" style="background:#f8fafc;">
            <tr>
                <th class="px-6 py-4">User / Operator</th>
                <th class="px-6 py-4">Action</th>
                <th class="px-6 py-4">Resource</th>
                <th class="px-6 py-4">Description</th>
                <th class="px-6 py-4">IP Address</th>
                <th class="px-6 py-4">Date & Time</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    <!-- User -->
                    <td class="px-6 py-4">
                        <?php if($log->user): ?>
                            <div class="font-semibold text-slate-800"><?php echo e($log->user->name); ?></div>
                            <div class="text-xs text-slate-400"><?php echo e(ucfirst($log->user->role)); ?></div>
                        <?php else: ?>
                            <div class="font-semibold text-slate-400">System / Guest</div>
                        <?php endif; ?>
                    </td>

                    <!-- Action Badge -->
                    <td class="px-6 py-4">
                        <?php if($log->action === 'created'): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                Created
                            </span>
                        <?php elseif($log->action === 'updated'): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                Updated
                            </span>
                        <?php elseif($log->action === 'deleted'): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                Deleted
                            </span>
                        <?php elseif($log->action === 'restored'): ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                                Restored
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                <?php echo e(ucfirst($log->action)); ?>

                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- Resource Class & Name/Tag -->
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded font-semibold text-xs text-slate-600 uppercase tracking-wide">
                            <?php echo e(class_basename($log->model_type)); ?>

                        </span>
                        <div class="text-xs font-bold font-mono text-slate-700 mt-1.5">
                            ID: <?php echo e($log->model_id); ?> (<?php echo e($log->model_label); ?>)
                        </div>
                    </td>

                    <!-- Description & Inspections -->
                    <td class="px-6 py-4 max-w-md">
                        <div class="text-slate-800 font-medium">
                            <?php echo e($log->description); ?>

                        </div>
                        
                        <!-- Value Inspections -->
                        <?php if(!empty($log->old_values) || !empty($log->new_values)): ?>
                            <details class="mt-2 group">
                                <summary class="text-xs text-blue-600 hover:text-blue-700 font-semibold cursor-pointer select-none outline-none">
                                    Show detail changes
                                </summary>
                                <div class="mt-2 text-xs bg-slate-50 border border-slate-200 rounded-lg p-3 grid grid-cols-1 md:grid-cols-2 gap-4 font-mono overflow-auto max-h-60 shadow-inner">
                                    <div>
                                        <div class="font-bold text-[10px] text-slate-400 uppercase tracking-wider mb-1 pb-1 border-b border-slate-200">Before Change</div>
                                        <?php if(!empty($log->old_values)): ?>
                                            <table class="w-full text-left">
                                                <tbody>
                                                    <?php $__currentLoopData = $log->old_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="pr-2 py-0.5 font-bold text-slate-500"><?php echo e($key); ?>:</td>
                                                            <td class="py-0.5 text-slate-700 break-all"><?php echo e(is_array($val) ? json_encode($val) : (is_bool($val) ? ($val ? 'true' : 'false') : $val)); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <span class="text-slate-400 italic">None / Created New</span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[10px] text-slate-400 uppercase tracking-wider mb-1 pb-1 border-b border-slate-200">After Change</div>
                                        <?php if(!empty($log->new_values)): ?>
                                            <table class="w-full text-left">
                                                <tbody>
                                                    <?php $__currentLoopData = $log->new_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="pr-2 py-0.5 font-bold text-slate-500"><?php echo e($key); ?>:</td>
                                                            <td class="py-0.5 text-slate-700 break-all"><?php echo e(is_array($val) ? json_encode($val) : (is_bool($val) ? ($val ? 'true' : 'false') : $val)); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <span class="text-slate-400 italic">None / Deleted</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </details>
                        <?php endif; ?>
                    </td>

                    <!-- IP Address -->
                    <td class="px-6 py-4 text-xs font-mono text-slate-600">
                        <?php echo e($log->ip_address ?? '—'); ?>

                    </td>

                    <!-- Created At -->
                    <td class="px-6 py-4 text-xs text-slate-600 whitespace-nowrap">
                        <div class="font-semibold"><?php echo e($log->created_at->format('M d, Y h:i A')); ?></div>
                        <div class="text-[10px] text-slate-400"><?php echo e($log->created_at->diffForHumans()); ?></div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                        No audit logs recorded yet.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <?php echo e($logs->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/activity-logs/index.blade.php ENDPATH**/ ?>