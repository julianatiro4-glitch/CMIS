@php($division = $division ?? null)

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Location</label>
        <select name="location_id" class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Select Location --</option>
            @foreach ($locations as $location)
                <option value="{{ $location->id }}" @selected(old('location_id', $division->location_id ?? '') == $location->id)>
                    {{ $location->name }}
                </option>
            @endforeach
        </select>
        @error('location_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Division / Section Name</label>
        <input type="text" name="name" value="{{ old('name', $division->name ?? '') }}"
               placeholder="e.g. Human Resources Division"
               class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Short Code <span class="text-slate-400 font-normal normal-case">(optional)</span>
        </label>
        <input type="text" name="code" value="{{ old('code', $division->code ?? '') }}"
               placeholder="e.g. HR, IT, FIN, ADMIN"
               class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p class="text-xs text-slate-400 mt-1">Short code used to identify the division quickly</p>
        @error('code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Description <span class="text-slate-400 font-normal normal-case">(optional)</span>
        </label>
        <textarea name="description" rows="3"
                  placeholder="Brief description of this division..."
                  class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $division->description ?? '') }}</textarea>
    </div>
</div>
