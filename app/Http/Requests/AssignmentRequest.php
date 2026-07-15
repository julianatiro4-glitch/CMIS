<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManage() ?? false;
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'user_id' => ['required', 'exists:users,id'],
            'assigned_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
