<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">User Management</h1>
        <a href="<?php echo e(route('users.create')); ?>" class="bg-slate-800 text-white px-4 py-2 rounded text-sm">+ New User</a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Joined</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            <?php echo e($user->name); ?>

                            <?php if($user->id === auth()->id()): ?>
                                <span class="text-xs text-gray-400">(you)</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2"><?php echo e($user->email); ?></td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs bg-gray-100">
                                <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                            </span>
                        </td>
                        <td class="px-4 py-2"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-amber-600 hover:underline">Edit</a>
                            <?php if($user->id !== auth()->id()): ?>
                                <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this user?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/users/index.blade.php ENDPATH**/ ?>