<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'lowercase', 'unique:users,email'],
            'curriculum_id' => ['required', 'exists:curricula,id'],
            'grade_level_id' => ['required', 'exists:grade_levels,id'],
            'section_id' => ['nullable', 'exists:sections,id'],
        ];
    }

    /**
     * Custom validation messages for creating a child.
     */
    public function messages(): array
    {
        return [
            // Child name
            'name.required' => 'Please enter the full name of the child.',
            'name.string'   => 'The child’s name must be valid text.',
            'name.max'      => 'The child’s name may not exceed 255 characters.',

            // Child email
            'email.required' => 'Please provide an email address for the child.',
            'email.email'    => 'Please enter a valid email address (e.g., child@example.com).',
            'email.max'      => 'The email address may not exceed 255 characters.',
            'email.lowercase' => 'The email address must be in lowercase.',
            'email.unique'   => 'This email is already registered in the system.',

            // Curriculum
            'curriculum_id.required' => 'Please assign a curriculum for the child.',
            'curriculum_id.exists'   => 'The selected curriculum does not exist.',

            // Grade level
            'grade_level_id.required' => 'Please assign a grade level for the child.',
            'grade_level_id.exists'  => 'The selected grade level does not exist.',

            // Section
            'section_id.exists'      => 'The selected section does not exist. Please choose a valid section.',
        ];
    }
}
