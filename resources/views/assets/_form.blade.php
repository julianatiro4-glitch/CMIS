@csrf
@php $asset = $asset ?? null; @endphp

{{-- SECTION 1: BASIC INFORMATION --}}
<div class="mb-7">
    <div class="flex items-center gap-2 mb-5 pb-2 border-b-2 border-slate-100">
        <span class="w-7 h-7 rounded-lg bg-slate-800 text-white text-xs flex items-center justify-center font-bold flex-shrink-0">1</span>
        <h3 class="font-bold text-slate-700 text-base">Basic Information</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Asset Tag</label>
            <input type="text" name="asset_tag" value="{{ old('asset_tag', $asset->asset_tag ?? ($nextAssetTag ?? '')) }}" placeholder="CMP-0001" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-xs text-slate-400 mt-1">Auto-generated — change if needed.</p>
            @error('asset_tag') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Asset Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $asset->name ?? '') }}" placeholder="e.g. Dell Desktop PC, HP Laptop" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <p class="text-xs text-slate-400 mt-1">Brief description or model name of the asset</p>
            @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Serial Number</label>
            <input type="text" name="serial_number" value="{{ old('serial_number', $asset->serial_number ?? '') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('serial_number') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Brand</label>
            <input type="text" name="brand" value="{{ old('brand', $asset->brand ?? '') }}" placeholder="e.g. Dell, HP, Lenovo" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Equipment Type</label>
            <select name="category_id" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Type --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $asset->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Status</label>
            <select name="status" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $asset->status ?? 'available') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Physical Condition</label>
            <select name="condition" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach (\App\Models\Asset::CONDITIONS as $condition)
                    <option value="{{ $condition }}" @selected(old('condition', $asset->condition ?? 'good') === $condition)>{{ ucfirst(str_replace('_', ' ', $condition)) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Ownership</label>
            <select name="ownership_type" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="office_owned" @selected(old('ownership_type', $asset->ownership_type ?? 'office_owned') === 'office_owned')>Office-Owned</option>
                <option value="personally_owned" @selected(old('ownership_type', $asset->ownership_type ?? '') === 'personally_owned')>Personally Owned</option>
            </select>
        </div>
    </div>
</div>

{{-- SECTION 2: HARDWARE SPECIFICATIONS --}}
<div class="mb-7">
    <div class="flex items-center gap-2 mb-5 pb-2 border-b-2 border-blue-100">
        <span class="w-7 h-7 rounded-lg bg-blue-600 text-white text-xs flex items-center justify-center font-bold flex-shrink-0">2</span>
        <h3 class="font-bold text-slate-700 text-base">Hardware Specifications</h3>
        <span class="text-xs text-slate-400">CPU, RAM, Storage, OS, Hostname</span>
    </div>
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="sm:col-span-2 lg:col-span-3">
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">CPU / Processor</label>
                <input type="text" name="cpu" value="{{ old('cpu', $asset->cpu ?? '') }}" placeholder="e.g. Intel Core i5-14400, AMD Ryzen 5 5600G, Intel i7-14700" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">Memory (Used / Total)</label>
                <select name="ram_total" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Memory --</option>
                    @foreach (\App\Models\Asset::RAM_OPTIONS as $ram)
                        <option value="{{ $ram }}" @selected(old('ram_total', $asset->ram_total ?? '') === $ram)>{{ $ram }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">Storage Capacity</label>
                <select name="storage_capacity" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Storage --</option>
                    @foreach (\App\Models\Asset::STORAGE_OPTIONS as $storage)
                        <option value="{{ $storage }}" @selected(old('storage_capacity', $asset->storage_capacity ?? '') === $storage)>{{ $storage }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">Storage Device Model</label>
                <input type="text" name="storage_device" value="{{ old('storage_device', $asset->storage_device ?? '') }}" placeholder="e.g. Samsung 870 EVO, WD Blue SN580" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">Operating System</label>
                <select name="operating_system" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select OS --</option>
                    @foreach (\App\Models\Asset::OS_OPTIONS as $os)
                        <option value="{{ $os }}" @selected(old('operating_system', $asset->operating_system ?? '') === $os)>{{ $os }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-blue-800 mb-1.5 uppercase tracking-wide">Hostname / Computer Name</label>
                <input type="text" name="hostname" value="{{ old('hostname', $asset->hostname ?? '') }}" placeholder="e.g. PESO-PC-001, LMISD-LAP-03" class="w-full border border-blue-200 rounded-lg px-3 py-2.5 text-sm font-mono bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Software Installed</label>
            <textarea name="software_installed" rows="3" placeholder="e.g. MS Office 2021, Google Chrome, Adobe Reader..." class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('software_installed', $asset->software_installed ?? '') }}</textarea>
        </div>
        <div>
            <label class="flex items-start gap-3 cursor-pointer bg-slate-50 rounded-xl px-4 py-4 border border-slate-200 h-full">
                <input type="hidden" name="has_crowdstrike" value="0">
                <input type="checkbox" name="has_crowdstrike" value="1" @checked(old('has_crowdstrike', $asset->has_crowdstrike ?? false)) class="w-5 h-5 rounded border-slate-300 text-blue-600 mt-0.5 flex-shrink-0">
                <div>
                    <span class="text-sm font-bold text-slate-700">CrowdStrike Installed</span>
                    <p class="text-xs text-slate-400 mt-1">Check if CrowdStrike Falcon endpoint protection is installed on this unit</p>
                </div>
            </label>
        </div>
    </div>
</div>

{{-- SECTION 3: DIVISION AND USER --}}
<div class="mb-7">
    <div class="flex items-center gap-2 mb-5 pb-2 border-b-2 border-purple-100">
        <span class="w-7 h-7 rounded-lg bg-purple-600 text-white text-xs flex items-center justify-center font-bold flex-shrink-0">3</span>
        <h3 class="font-bold text-slate-700 text-base">Division and User Assignment</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Division / Section</label>
            <select name="division_id" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Select Division --</option>
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}" @selected(old('division_id', $asset->division_id ?? '') == $division->id)>{{ $division->code ? '['.$division->code.'] ' : '' }}{{ $division->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Utilized By / End User</label>
            <input type="text" name="utilized_by" value="{{ old('utilized_by', $asset->utilized_by ?? '') }}" placeholder="Full name of the person using this unit" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Connectivity</label>
            <select name="connectivity" id="connectivity_select" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="document.getElementById('wifi_row').style.display=['wifi','both'].includes(this.value)?'':'none';">
                <option value="lan"  @selected(old('connectivity', $asset->connectivity ?? 'lan') === 'lan')>LAN (Wired)</option>
                <option value="wifi" @selected(old('connectivity', $asset->connectivity ?? '') === 'wifi')>WiFi (Wireless)</option>
                <option value="both" @selected(old('connectivity', $asset->connectivity ?? '') === 'both')>Both LAN and WiFi</option>
                <option value="none" @selected(old('connectivity', $asset->connectivity ?? '') === 'none')>No Internet</option>
            </select>
        </div>
        <div id="wifi_row" style="{{ in_array(old('connectivity', $asset->connectivity ?? 'lan'), ['wifi','both']) ? '' : 'display:none' }}">
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">WiFi Network (SSID)</label>
            <input type="text" name="wifi_network" value="{{ old('wifi_network', $asset->wifi_network ?? '') }}" placeholder="e.g. PESO-WIFI-5G" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>
</div>

{{-- SECTION 4: PURCHASE INFORMATION --}}
<div class="mb-2">
    <div class="flex items-center gap-2 mb-5 pb-2 border-b-2 border-amber-100">
        <span class="w-7 h-7 rounded-lg bg-amber-500 text-white text-xs flex items-center justify-center font-bold flex-shrink-0">4</span>
        <h3 class="font-bold text-slate-700 text-base">Purchase Information</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Purchase Date</label>
            <input type="date" name="purchase_date" value="{{ old('purchase_date', isset($asset) ? $asset->purchase_date?->format('Y-m-d') : '') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Purchase Cost</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">P</span>
                <input type="number" step="0.01" name="purchase_cost" value="{{ old('purchase_cost', $asset->purchase_cost ?? '') }}" class="w-full border border-slate-200 rounded-lg pl-7 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Warranty Expiry</label>
            <input type="date" name="warranty_expiry" value="{{ old('warranty_expiry', isset($asset) ? $asset->warranty_expiry?->format('Y-m-d') : '') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('warranty_expiry') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="sm:col-span-2 lg:col-span-3">
            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide">Notes / Remarks</label>
            <textarea name="notes" rows="2" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $asset->notes ?? '') }}</textarea>
        </div>
    </div>
</div>
