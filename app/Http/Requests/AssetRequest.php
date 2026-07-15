<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManage() ?? false;
    }

    public function rules(): array
    {
        $assetId = $this->route('asset')?->id;
        return [
            'asset_tag'          => ['nullable', 'string', 'max:50', Rule::unique('assets','asset_tag')->ignore($assetId)],
            'name'               => ['required', 'string', 'max:255'],
            'category_id'        => ['required', 'exists:categories,id'],
            'location_id'        => ['nullable', 'exists:locations,id'],
            'division_id'        => ['nullable', 'exists:divisions,id'],
            'brand'              => ['nullable', 'string', 'max:100'],
            'model'              => ['nullable', 'string', 'max:100'],
            'serial_number'      => ['nullable', 'string', 'max:150', Rule::unique('assets','serial_number')->ignore($assetId)],
            'status'             => ['required', Rule::in(Asset::STATUSES)],
            'purchase_date'      => ['nullable', 'date'],
            'purchase_cost'      => ['nullable', 'numeric', 'min:0'],
            'warranty_expiry'    => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'specifications'     => ['nullable', 'string'],
            'notes'              => ['nullable', 'string'],
            'cpu'                => ['nullable', 'string', 'max:255'],
            'ram_total'          => ['nullable', 'string', 'max:50'],
            'ram_used'           => ['nullable', 'string', 'max:50'],
            'storage_capacity'   => ['nullable', 'string', 'max:50'],
            'storage_device'     => ['nullable', 'string', 'max:255'],
            'operating_system'   => ['nullable', 'string', 'max:100'],
            'hostname'           => ['nullable', 'string', 'max:100'],
            'utilized_by'        => ['nullable', 'string', 'max:255'],
            'ownership_type'     => ['nullable', Rule::in(Asset::OWNERSHIP_TYPES)],
            'connectivity'       => ['nullable', Rule::in(Asset::CONNECTIVITY_TYPES)],
            'wifi_network'       => ['nullable', 'string', 'max:100'],
            'condition'          => ['nullable', Rule::in(Asset::CONDITIONS)],
            'software_installed' => ['nullable', 'string'],
            'has_crowdstrike'    => ['nullable', 'boolean'],
        ];
    }
}