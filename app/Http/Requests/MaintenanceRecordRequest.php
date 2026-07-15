<?php

namespace App\Http\Requests;

use App\Models\MaintenanceRecord;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaintenanceRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManage() ?? false;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'technician' => ['nullable', 'string', 'max:150'],
            'issue_description' => ['required', 'string'],
            'status' => ['required', Rule::in(MaintenanceRecord::STATUSES)],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'resolution_notes' => ['nullable', 'string'],
            'opened_at' => ['required', 'date'],
            'resolved_at' => ['nullable', 'date', 'after_or_equal:opened_at'],
        ];
    }
}