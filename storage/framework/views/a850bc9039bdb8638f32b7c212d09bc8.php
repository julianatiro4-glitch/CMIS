<?php $__env->startSection('title', 'Categories'); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Categories</h1>
        <a href="<?php echo e(route('categories.create')); ?>" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ New Category</a>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2"># Assets</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t">
                        <td class="px-4 py-2"><?php echo e($category->name); ?></td>
                        <td class="px-4 py-2"><?php echo e($category->description ?? '—'); ?></td>
                        <td class="px-4 py-2"><?php echo e($category->assets_count); ?></td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="<?php echo e(route('categories.edit', $category)); ?>" class="text-amber-600 hover:underline">Edit</a>
                            <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this category?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No categories found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4"><?php echo e($categories->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/categories/index.blade.php ENDPATH**/ ?>