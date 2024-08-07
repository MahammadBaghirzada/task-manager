<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'min:3', 'max:191'],
            'is_done' => ['sometimes', 'boolean'],
            'project_id' => [
                'nullable',
                Rule::in(Auth::user()->memberships()->pluck('id'))
            ],
            'scheduled_at' => ['sometimes', 'date', 'nullable'],
            'due_at' => ['sometimes', 'date', 'nullable'],
        ];
    }
}
