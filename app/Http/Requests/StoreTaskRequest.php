<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'min:3', 'max:191'],
            'project_id' => [
                'nullable',
                Rule::in(Auth::user()->memberships()->pluck('id')),
            ],
            'scheduled_at' => ['date', 'nullable'],
            'due_at' => ['date', 'nullable'],
        ];
    }
}
