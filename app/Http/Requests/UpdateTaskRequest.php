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
                Rule::exists('projects', 'id')->where(function ($query) {
                    $query->where('creator_id', Auth::id());
                })
            ],
        ];
    }
}
