@php($user = $user ?? null)

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Name</label>
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
           class="w-full border rounded px-3 py-2 text-sm">
    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
           class="w-full border rounded px-3 py-2 text-sm">
    @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Role</label>
    <select name="role" class="w-full border rounded px-3 py-2 text-sm">
        @foreach ($roles as $role)
            <option value="{{ $role }}" @selected(old('role', $user->role ?? 'it_staff') === $role)>
                {{ ucfirst(str_replace('_', ' ', $role)) }}
            </option>
        @endforeach
    </select>
    @error('role') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">
        Password
        @if ($user)
            <span class="text-xs text-gray-400 font-normal">(leave blank to keep current password)</span>
        @endif
    </label>
    <input type="password" name="password" class="w-full border rounded px-3 py-2 text-sm">
    @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>