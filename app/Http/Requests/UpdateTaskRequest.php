<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
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
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status'      => ['required', Rule::in(Task::STATUSES)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Please enter a task title.',
            'status.required' => 'Please choose a task status.',
            'status.in'       => 'Status must be either Pending or Completed.',
        ];
    }
}
