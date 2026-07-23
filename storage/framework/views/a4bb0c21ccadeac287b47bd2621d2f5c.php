<?php ($location = $location ?? null); ?>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Name</label>
    <input type="text" name="name" value="<?php echo e(old('name', $location->name ?? '')); ?>" class="w-full border rounded px-3 py-2 text-sm">
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<div class="grid grid-cols-3 gap-3 mb-4">
    <div>
        <label class="block text-sm font-medium mb-1">Building</label>
        <input type="text" name="building" value="<?php echo e(old('building', $location->building ?? '')); ?>" class="w-full border rounded px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Floor</label>
        <input type="text" name="floor" value="<?php echo e(old('floor', $location->floor ?? '')); ?>" class="w-full border rounded px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Room</label>
        <input type="text" name="room" value="<?php echo e(old('room', $location->room ?? '')); ?>" class="w-full border rounded px-3 py-2 text-sm">
    </div>
</div>
<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Notes</label>
    <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2 text-sm"><?php echo e(old('notes', $location->notes ?? '')); ?></textarea>
</div>
<?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/locations/_fields.blade.php ENDPATH**/ ?>