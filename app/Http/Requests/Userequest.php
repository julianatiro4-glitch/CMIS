<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManage() ?? false;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;
        $isCreating = $this->isMethod('post');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'role' => ['required', Rule::in(User::ROLES)],
            'password' => [$isCreating ? 'required' : 'nullable', Password::min(8)],
        ];
    }
}