@extends('layouts.app')

@section('title', 'Trash')

@section('content')
    <form id="bulk-delete-form" action="{{ route('assets.bulk-force-delete') }}" method="POST" class="hidden" onsubmit="return confirm('Are you sure you want to permanently delete the selected assets? This cannot be undone.');">
        @csrf
    </form>

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold">Trash</h1>
            @if(auth()->user()->canManage())
            <button type="submit" id="bulk-delete-btn" form="bulk-delete-form" class="hidden items-center gap-1.5 text-xs font-semibold text-white bg-red-600 px-3 py-1.5 rounded-lg hover:bg-red-700 transition-colors shadow">
                Delete Selected (<span id="bulk-count">0</span>)
            </button>
            @endif
        </div>
        <a href="{{ route('assets.index') }}" class="border px-4 py-2 rounded text-sm">Back to Assets</a>
    </div>

    <p class="text-sm text-gray-500 mb-4">
        Retired/deleted assets are kept here. Restore them to bring them back, or permanently delete
        if you're sure they're gone for good.
    </p>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    @if(auth()->user()->canManage())
                    <th class="px-4 py-2 w-10"><input type="checkbox" id="select-all" class="rounded border-gray-300 text-navy focus:ring-navy w-4 h-4 cursor-pointer"></th>
                    @endif
                    <th class="px-4 py-2">Tag</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Deleted At</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assets as $asset)
                    <tr class="border-t">
                        @if(auth()->user()->canManage())
                        <td class="px-4 py-2">
                            <input type="checkbox" name="ids[]" value="{{ $asset->id }}" form="bulk-delete-form" class="asset-checkbox rounded border-gray-300 text-navy focus:ring-navy w-4 h-4 cursor-pointer">
                        </td>
                        @endif
                        <td class="px-4 py-2 font-mono">{{ $asset->asset_tag }}</td>
                        <td class="px-4 py-2">{{ $asset->name }}</td>
                        <td class="px-4 py-2">{{ $asset->category->name }}</td>
                        <td class="px-4 py-2">{{ $asset->deleted_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <form action="{{ route('assets.restore', $asset->id) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline">Restore</button>
                            </form>
                            <form action="{{ route('assets.force-delete', $asset->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Permanently delete this asset? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete Forever</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->canManage() ? '6' : '5' }}" class="px-4 py-6 text-center text-gray-500">Trash is empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $assets->links() }}
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
@endsection