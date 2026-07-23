<?php $__env->startSection('title', 'New Location'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-2xl font-bold mb-6">New Location</h1>

    <form method="POST" action="<?php echo e(route('locations.store')); ?>" class="bg-white p-6 rounded shadow max-w-lg">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('locations._fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="flex gap-3 mt-4">
            <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Save</button>
            <a href="<?php echo e(route('locations.index')); ?>" class="px-4 py-2 rounded text-sm border">Cancel</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/locations/create.blade.php ENDPATH**/ ?>