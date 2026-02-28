<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $rules = [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'lowercase', 'unique:users,email'],
            'phone'     => ['nullable', 'string', 'max:20', 'unique:users,phone'],
            'role_id'   => ['required', 'in:parent,teacher,admin'],
        ];

        if ($this->role_id === 'parent') {
            $rules['children'] = ['required', 'array', 'min:1'];
            $rules['children.*.name'] = ['required', 'string', 'max:255'];
            $rules['children.*.email'] = ['required', 'email', 'max:255', 'lowercase', 'unique:users,email'];
            $rules['children.*.curriculum_id'] = ['required', 'exists:curricula,id'];
            $rules['children.*.grade_level_id'] = ['required', 'exists:grade_levels,id'];
            $rules['children.*.section_id'] = ['nullable', 'exists:sections,id'];
        }

        return $rules;
    }

    /**
     * Get custom validation messages for user creation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // User details
            'name.required' => 'Please enter the user’s full name.',
            'name.string' => 'The name must be a valid text value.',
            'name.max' => 'The name may not exceed 255 characters.',

            'email.required' => 'Please provide an email address for the user.',
            'email.email' => 'Please enter a valid email address (e.g., user@example.com).',
            'email.max' => 'The email address may not exceed 255 characters.',
            'email.lowercase' => 'The email address must be in lowercase.',
            'email.unique' => 'This email is already registered in the system.',

            'phone.string' => 'The phone number must contain valid characters only.',
            'phone.max' => 'The phone number may not exceed 20 characters.',
            'phone.unique' => 'This phone number is already in use.',

            'role_id.required' => 'Please assign a role to the user (Parent, Teacher, or Admin).',
            'role_id.in' => 'The selected role is invalid. Please choose Parent, Teacher, or Admin.',

            // Children details (for parents)
            'children.required' => 'Please add at least one child for this parent account.',
            'children.array' => 'Invalid data format for children. Please try again.',
            'children.min' => 'You must add at least one child before saving.',

            'children.*.name.required' => 'Each child must have a name.',
            'children.*.name.string' => 'The child’s name must be valid text.',
            'children.*.name.max' => 'The child’s name may not exceed 255 characters.',

            'children.*.email.required' => 'Each child must have an email address.',
            'children.*.email.email' => 'Each child’s email must be a valid email address.',
            'children.*.email.max' => 'The child’s email address may not exceed 255 characters.',
            'children.*.email.lowercase' => 'The child’s email address must be in lowercase.',
            'children.*.email.unique' => 'This child’s email is already registered in the system.',

            'children.*.curriculum_id.required' => 'Please assign a curriculum for each child.',
            'children.*.curriculum_id.exists' => 'One or more selected curricula do not exist.',

            'children.*.grade_level_id.required' => 'Please assign a grade level for each child.',
            'children.*.grade_level_id.exists' => 'One or more selected grade levels do not exist.',

            'children.*.section_id.exists' => 'The selected section does not exist. Please choose a valid section.',
        ];
    }
}
