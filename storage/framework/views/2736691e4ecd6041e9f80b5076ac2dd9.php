<?php $__env->startSection('title', 'Edit — ' . $asset->asset_tag); ?>
<?php $__env->startSection('subtitle', $asset->name); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?php echo e(route('assets.show', $asset)); ?>" class="text-slate-400 hover:text-slate-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h2 class="text-lg font-bold text-slate-800">Edit Asset</h2>
        <p class="text-sm text-slate-400"><?php echo e($asset->asset_tag); ?> — <?php echo e($asset->name); ?></p>
    </div>
</div>
<form method="POST" action="<?php echo e(route('assets.update', $asset)); ?>" class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
    <?php echo method_field('PUT'); ?>
    <?php echo $__env->make('assets._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="flex gap-3 mt-6 pt-5 border-t border-slate-100">
        <button class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg hover:opacity-90 shadow" style="background:#0d2a5e;">Save Changes</button>
        <a href="<?php echo e(route('assets.show', $asset)); ?>" class="px-6 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">Cancel</a>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/assets/edit.blade.php ENDPATH**/ ?>