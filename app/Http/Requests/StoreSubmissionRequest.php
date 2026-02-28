<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
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
            'assignment_id' => ['required', 'exists:assignments,id'],
            'remarks' => ['nullable', 'string'],
            'uploaded_files' => ['nullable', 'string'], // JSON from FilePond
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'assignment_id.required' => 'You need to select an assignment before submitting.',
            'assignment_id.exists' => 'Hmm… that assignment doesn’t exist. Are you trying to cheat? 😅',
            'remarks.string' => 'Your remarks must be text. Numbers and emojis are okay too, but no arrays!',
            'uploaded_files.string' => 'The uploaded files should be a valid JSON string from FilePond.',
        ];
    }
}
