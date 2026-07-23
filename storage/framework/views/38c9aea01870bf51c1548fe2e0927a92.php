<?php $__env->startSection('title', 'Open Technical Support Ticket'); ?>
<?php $__env->startSection('subtitle', 'Report an issue and log a technical support ticket'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-800">New Technical Support Ticket</h1>
        <a href="<?php echo e(route('technical_support.index')); ?>" class="text-xs text-slate-500 hover:text-slate-800 font-semibold flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to list
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-slate-100 p-6">
        <form action="<?php echo e(route('technical_support.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Date selection -->
            <div class="mb-4">
                <label for="date" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Date & Time</label>
                <input type="datetime-local" name="date" id="date" 
                       value="<?php echo e(old('date', now()->format('Y-m-d\TH:i'))); ?>" 
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Division -->
            <div class="mb-4">
                <label for="division" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Division</label>
                <select name="division" id="division" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy <?php $__errorArgs = ['division'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">-- Select Division --</option>
                    <?php $__currentLoopData = ['PED', 'LMISD', 'Admin', 'SPD', 'OPM', 'LRSD', 'DOC', 'MSD']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $div): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($div); ?>" <?php echo e(old('division') == $div ? 'selected' : ''); ?>><?php echo e($div); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['division'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Reported By -->
            <div class="mb-4">
                <label for="reported_by" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Reported By</label>
                <input type="text" name="reported_by" id="reported_by" placeholder="e.g. Mam Ara" 
                       value="<?php echo e(old('reported_by')); ?>"
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy <?php $__errorArgs = ['reported_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['reported_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Handled By -->
            <div class="mb-4">
                <label for="handled_by" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Handled By</label>
                <input type="text" name="handled_by" id="handled_by" placeholder="Technician name" 
                       value="<?php echo e(old('handled_by')); ?>"
                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy <?php $__errorArgs = ['handled_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['handled_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Status selection -->
            <div class="mb-4">
                <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Ticket Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="in_progress" <?php echo e(old('status', 'in_progress') == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                    <option value="for_checking" <?php echo e(old('status') == 'for_checking' ? 'selected' : ''); ?>>For Checking</option>
                    <option value="failed" <?php echo e(old('status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                    <option value="done" <?php echo e(old('status') == 'done' ? 'selected' : ''); ?>>Done</option>
                </select>
                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Issue Description -->
            <div class="mb-6">
                <label for="issue_problem" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Issue / Problem</label>
                <textarea name="issue_problem" id="issue_problem" rows="4" placeholder="Detailed description of the issue..." 
                          class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy <?php $__errorArgs = ['issue_problem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('issue_problem')); ?></textarea>
                <?php $__errorArgs = ['issue_problem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Resolution Fields (conditional/optional) -->
            <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 mb-6">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-3">Resolution Details</h3>

                <div>
                    <label for="action_taken" class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Action Taken</label>
                    <textarea name="action_taken" id="action_taken" rows="3" placeholder="Action taken to fix the issue..." 
                              class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-navy <?php $__errorArgs = ['action_taken'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('action_taken')); ?></textarea>
                    <?php $__errorArgs = ['action_taken'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3 justify-end border-t border-slate-100 pt-4">
                <a href="<?php echo e(route('technical_support.index')); ?>" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 rounded-lg text-sm font-semibold transition-colors">Cancel</a>
                <button type="submit" class="bg-navy hover:bg-navy-light text-white px-5 py-2 rounded-lg text-sm font-semibold shadow transition-colors">
                    Save Ticket
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/technical_support/create.blade.php ENDPATH**/ ?>