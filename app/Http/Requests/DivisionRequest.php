<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManage() ?? false;
    }

    public function rules(): array
    {
        return [
            'location_id'  => ['required', 'exists:locations,id'],
            'name'         => ['required', 'string', 'max:255'],
            'code'         => ['nullable', 'string', 'max:20'],
            'description'  => ['nullable', 'string'],
        ];
    }
}