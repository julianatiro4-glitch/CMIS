<?php echo csrf_field(); ?>
<?php $asset = $asset ?? null; ?>


<div class="mb-7">
    <div class="flex items-center gap-2 mb-5 pb-2 border-b-2 border-slate-100">
        <span class="w-7 h-7 rounded-lg bg-slate-800 text-white text-xs flex items-center justify-center font-bold flex-shrink-0">1</span>
        <h3 class="font-bold text-slate-700 text-base">Basic Information</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Asset Tag</label>
            <input type="text" name="asset_tag" value="<?php echo e(old('asset_tag', $asset->asset_tag ?? ($nextAssetTag ?? ''))); ?>" placeholder="CMP-0001" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-xs text-slate-400 mt-1">Auto-generated — change if needed.</p>
            <?php $__errorArgs = ['asset_tag'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Asset Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="<?php echo e(old('name', $asset->name ?? '')); ?>" placeholder="e.g. Dell Desktop PC, HP Laptop" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <p class="text-xs text-slate-400 mt-1">Brief description or model name of the asset</p>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Serial Number</label>
            <input type="text" name="serial_number" value="<?php echo e(old('serial_number', $asset->serial_number ?? '')); ?>" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
            <?php $__errorArgs = ['serial_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Equipment Type</label>
            <select name="category_id" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Type --</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php if(old('category_id', $asset->category_id ?? '') == $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Condition</label>
            <select name="condition" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php $__currentLoopData = \App\Models\Asset::CONDITIONS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($condition); ?>" <?php if(old('condition', $asset->condition ?? 'good') === $condition): echo 'selected'; endif; ?>><?php echo e(ucfirst(str_replace('_', ' ', $condition))); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Ownership</label>
            <select name="ownership_type" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="office_owned" <?php if(old('ownership_type', $asset->ownership_type ?? 'office_owned') === 'office_owned'): echo 'selected'; endif; ?>>Office-Owned</option>
                <option value="personally_owned" <?php if(old('ownership_type', $asset->ownership_type ?? '') === 'personally_owned'): echo 'selected'; endif; ?>>Personally Owned</option>
            </select>
        </div>
    </div>
</div>


<div class="mb-7">
    <div class="flex items-center gap-2 mb-5 pb-2 border-b-2 border-blue-100">
        <span class="w-7 h-7 rounded-lg bg-blue-600 text-white text-xs flex items-center justify-center font-bold flex-shrink-0">2</span>
        <h3 class="font-bold text-slate-700 text-base">Hardware Specifications</h3>
        <span class="text-xs text-slate-400">CPU, RAM, Storage, OS</span>
    </div>
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="sm:col-span-2 lg:col-span-3">
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">CPU / Processor</label>
                <input type="text" name="cpu" value="<?php echo e(old('cpu', $asset->cpu ?? '')); ?>" placeholder="e.g. Intel Core i5-14400, AMD Ryzen 5 5600G, Intel i7-14700" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">Memory (Used / Total)</label>
                <select name="ram_total" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Memory --</option>
                    <?php $__currentLoopData = \App\Models\Asset::RAM_OPTIONS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ram): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ram); ?>" <?php if(old('ram_total', $asset->ram_total ?? '') === $ram): echo 'selected'; endif; ?>><?php echo e($ram); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">Storage Capacity</label>
                <select name="storage_capacity" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Storage --</option>
                    <?php $__currentLoopData = \App\Models\Asset::STORAGE_OPTIONS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($storage); ?>" <?php if(old('storage_capacity', $asset->storage_capacity ?? '') === $storage): echo 'selected'; endif; ?>><?php echo e($storage); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">Operating System</label>
                <select name="operating_system" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select OS --</option>
                    <?php $__currentLoopData = \App\Models\Asset::OS_OPTIONS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $os): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($os); ?>" <?php if(old('operating_system', $asset->operating_system ?? '') === $os): echo 'selected'; endif; ?>><?php echo e($os); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Software Installed</label>
            <textarea name="software_installed" rows="3" placeholder="e.g. MS Office 2021, Google Chrome, Adobe Reader..." class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo e(old('software_installed', $asset->software_installed ?? '')); ?></textarea>
        </div>
        <div>
            <label class="flex items-start gap-3 cursor-pointer bg-slate-50 rounded-xl px-4 py-4 border border-slate-200 h-full">
                <input type="hidden" name="has_crowdstrike" value="0">
                <input type="checkbox" name="has_crowdstrike" value="1" <?php if(old('has_crowdstrike', $asset->has_crowdstrike ?? false)): echo 'checked'; endif; ?> class="w-5 h-5 rounded border-slate-300 text-blue-600 mt-0.5 flex-shrink-0">
                <div>
                    <span class="text-sm font-bold text-slate-700">CrowdStrike Installed</span>
                    <p class="text-xs text-slate-400 mt-1">Check if CrowdStrike Falcon endpoint protection is installed on this unit</p>
                </div>
            </label>
        </div>
    </div>
</div>


<div class="mb-7">
    <div class="flex items-center gap-2 mb-5 pb-2 border-b-2 border-purple-100">
        <span class="w-7 h-7 rounded-lg bg-purple-600 text-white text-xs flex items-center justify-center font-bold flex-shrink-0">3</span>
        <h3 class="font-bold text-slate-700 text-base">Division and User Details</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Division / Section</label>
            <select name="division_id" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Division --</option>
                <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($division->id); ?>" <?php if(old('division_id', $asset->division_id ?? '') == $division->id): echo 'selected'; endif; ?>><?php echo e($division->code ? '['.$division->code.'] ' : ''); ?><?php echo e($division->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Utilized By / End User</label>
            <input type="text" name="utilized_by" value="<?php echo e(old('utilized_by', $asset->utilized_by ?? '')); ?>" placeholder="Full name of the person using this unit" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Connectivity</label>
            <select name="connectivity" id="connectivity_select" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="document.getElementById('wifi_row').style.display=['wifi','both'].includes(this.value)?'':'none';">
                <option value="lan"  <?php if(old('connectivity', $asset->connectivity ?? 'lan') === 'lan'): echo 'selected'; endif; ?>>LAN (Wired)</option>
                <option value="wifi" <?php if(old('connectivity', $asset->connectivity ?? '') === 'wifi'): echo 'selected'; endif; ?>>WiFi (Wireless)</option>
                <option value="both" <?php if(old('connectivity', $asset->connectivity ?? '') === 'both'): echo 'selected'; endif; ?>>Both LAN and WiFi</option>
                <option value="none" <?php if(old('connectivity', $asset->connectivity ?? '') === 'none'): echo 'selected'; endif; ?>>No Internet</option>
            </select>
        </div>
        <div id="wifi_row" style="<?php echo e(in_array(old('connectivity', $asset->connectivity ?? 'lan'), ['wifi','both']) ? '' : 'display:none'); ?>">
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">WiFi Network (SSID)</label>
            <input type="text" name="wifi_network" value="<?php echo e(old('wifi_network', $asset->wifi_network ?? '')); ?>" placeholder="e.g. PESO-WIFI-5G" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>
</div>


<div class="mb-2">
    <div class="flex items-center gap-2 mb-5 pb-2 border-b-2 border-slate-100">
        <h3 class="font-bold text-slate-700 text-base">Notes & Remarks</h3>
    </div>
    <div>
        <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Notes / Remarks</label>
        <textarea name="notes" rows="3" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo e(old('notes', $asset->notes ?? '')); ?></textarea>
    </div>
</div>
<?php /**PATH C:\Users\JulianaTiro\cmis\resources\views/assets/_form.blade.php ENDPATH**/ ?>