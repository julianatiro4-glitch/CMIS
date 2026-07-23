<?php $__env->startSection('title', 'Trash'); ?>

<?php $__env->startSection('content'); ?>
    <form id="bulk-delete-form" action="<?php echo e(route('assets.bulk-force-delete')); ?>" method="POST" class="hidden" onsubmit="return confirm('Are you sure you want to permanently delete the selected assets? This cannot be undone.');">
        <?php echo csrf_field(); ?>
    </form>

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold">Trash</h1>
            <?php if(auth()->user()->canManage()): ?>
            <button type="submit" id="bulk-delete-btn" form="bulk-delete-form" class="hidden items-center gap-1.5 text-xs font-semibold text-white bg-red-600 px-3 py-1.5 rounded-lg hover:bg-red-700 transition-colors shadow">
                Delete Selected (<span id="bulk-count">0</span>)
            </button>
            <?php endif; ?>
        </div>
        <a href="<?php echo e(route('assets.index')); ?>" class="border px-4 py-2 rounded text-sm">Back to Assets</a>
    </div>

    <p class="text-sm text-gray-500 mb-4">
        Retired/deleted assets are kept here. Restore them to bring them back, or permanently delete
        if you're sure they're gone for good.
    </p>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <?php if(auth()->user()->canManage()): ?>
                    <th class="px-4 py-2 w-10"><input type="checkbox" id="select-all" class="rounded border-gray-300 text-navy focus:ring-navy w-4 h-4 cursor-pointer"></th>
                    <?php endif; ?>
                    <th class="px-4 py-2">Tag</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Deleted At</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t">
                        <?php if(auth()->user()->canManage()): ?>
                        <td class="px-4 py-2">
                            <input type="checkbox" name="ids[]" value="<?php echo e($asset->id); ?>" form="bulk-delete-form" class="asset-checkbox rounded border-gray-300 text-navy focus:ring-navy w-4 h-4 cursor-pointer">
                        </td>
                        <?php endif; ?>
                        <td class="px-4 py-2 font-mono"><?php echo e($asset->asset_tag); ?></td>
                        <td class="px-4 py-2"><?php echo e($asset->name); ?></td>
                        <td class="px-4 py-2"><?php echo e($asset->category->name); ?></td>
                        <td class="px-4 py-2"><?php echo e($asset->deleted_at->format('M d, Y H:i')); ?></td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <form action="<?php echo e(route('assets.restore', $asset->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button class="text-green-600 hover:underline">Restore</button>
                            </form>
                            <form action="<?php echo e(route('assets.force-delete', $asset->id)); ?>" method="POST" class="inline"
                                  onsubmit="return confirm('Permanently delete this asset? This cannot be undone.');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="text-red-600 hover:underline">Delete Forever</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="<?php echo e(auth()->user()->canManage() ? '6' : '5'); ?>" class="px-4 py-6 text-center text-gray-500">Trash is empty.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($assets->links()); ?>

    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const assetCheckboxes = document.querySelectorAll('.asset-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const bulkCount = document.getElementById('bulk-count');

    function updateBulkButton() {
        const checkedCount = document.querySelectorAll('.asset-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkDeleteBtn.classList.remove('hidden');
            bulkDeleteBtn.classList.add('inline-flex');
            bulkCount.textContent = checkedCount;
        } else {
            bulkDeleteBtn.classList.add('hidden');
            bulkDeleteBtn.classList.remove('inline-flex');
        }
    }

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            assetCheckboxes.forEach(cb => {
                cb.checked = selectAllCheckbox.checked;
            });
            updateBulkButton();
        });
    }

    assetCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if (!cb.checked) {
                selectAllCheckbox.checked = false;
            } else {
                const allChecked = Array.from(assetCheckboxes).every(c => c.checked);
                selectAllCheckbox.checked = allChecked;
            }
            updateBulkButton();
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/assets/trash.blade.php ENDPATH**/ ?>