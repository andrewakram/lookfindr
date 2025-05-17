<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TasksWithFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'member_id'     => 'sometimes|integer|exists:users,id',
            'status'        => 'sometimes|string|in:todo,in_progress,done',
            'due_date'      => 'sometimes|date_format:Y-m-d',
        ];
    }
}
