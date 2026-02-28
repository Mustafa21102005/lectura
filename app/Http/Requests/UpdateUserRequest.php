<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')->id;

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'lowercase', 'unique:users,email,' . $userId],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $userId],
        ];

        if ($this->route('user')->hasRole('student')) {
            $rules['curriculum_id']   = ['required', 'exists:curricula,id'];
            $rules['grade_level_id']  = ['required', 'exists:grade_levels,id'];
            $rules['section_id']      = ['nullable', 'exists:sections,id'];
        }

        return $rules;
    }

    /**
     * Custom validation messages for updating a user.
     */
    public function messages(): array
    {
        return [
            // Basic user info
            'name.required' => 'Please enter the user’s full name before saving.',
            'name.string'   => 'The name must contain valid text.',
            'name.max'      => 'The name may not exceed 255 characters.',

            'email.required' => 'Please provide an email address for the user.',
            'email.email'    => 'Please enter a valid email address (e.g., user@example.com).',
            'email.max'      => 'The email address may not exceed 255 characters.',
            'email.lowercase' => 'The email address must be in lowercase.',
            'email.unique'   => 'This email address is already registered to another user.',

            'phone.string'  => 'The phone number must contain valid characters only.',
            'phone.max'     => 'The phone number may not exceed 20 characters.',
            'phone.unique'  => 'This phone number is already registered to another user.',

            // Student-specific fields
            'curriculum_id.required'  => 'Please assign a curriculum to the student.',
            'curriculum_id.exists'    => 'The selected curriculum does not exist in the system.',

            'grade_level_id.required' => 'Please assign a grade level to the student.',
            'grade_level_id.exists'   => 'The selected grade level does not exist.',

            'section_id.exists'       => 'The selected section does not exist. Please choose a valid section.',
        ];
    }
}
