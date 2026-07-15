@php($location = $location ?? null)

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Name</label>
    <input type="text" name="name" value="{{ old('name', $location->name ?? '') }}" class="w-full border rounded px-3 py-2 text-sm">
    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>
<div class="grid grid-cols-3 gap-3 mb-4">
    <div>
        <label class="block text-sm font-medium mb-1">Building</label>
        <input type="text" name="building" value="{{ old('building', $location->building ?? '') }}" class="w-full border rounded px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Floor</label>
        <input type="text" name="floor" value="{{ old('floor', $location->floor ?? '') }}" class="w-full border rounded px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Room</label>
        <input type="text" name="room" value="{{ old('room', $location->room ?? '') }}" class="w-full border rounded px-3 py-2 text-sm">
    </div>
</div>
<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Notes</label>
    <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2 text-sm">{{ old('notes', $location->notes ?? '') }}</textarea>
</div>
