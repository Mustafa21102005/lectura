<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:subjects,name',
            'teacher_id' => 'required|integer|exists:users,id',
            'curricula' => 'required|array|min:1',
            'curricula.*' => 'integer|exists:curricula,id',
            'grade_levels' => 'required|array|min:1',
            'grade_levels.*' => 'integer|exists:grade_levels,id',
        ];
    }

    /**
     * Get custom validation messages for subject creation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Subject name
            'name.required' => 'Please enter a subject name before saving.',
            'name.string' => 'The subject name must be a valid text value.',
            'name.max' => 'The subject name is too long — please use 255 characters or fewer.',
            'name.unique' => 'A subject with this name already exists. Please use a different name.',

            // Teacher
            'teacher_id.required' => 'Please assign a teacher to this subject.',
            'teacher_id.integer' => 'The selected teacher ID must be a valid number.',
            'teacher_id.exists' => 'The selected teacher could not be found. Please choose an existing teacher.',

            // Curricula
            'curricula.required' => 'Please select at least one curriculum for this subject.',
            'curricula.array' => 'The curricula field must be a valid list of selected items.',
            'curricula.min' => 'Select at least one curriculum to continue.',
            'curricula.*.integer' => 'Each selected curriculum must have a valid ID.',
            'curricula.*.exists' => 'One or more selected curricula do not exist in the system.',

            // Grade levels
            'grade_levels.required' => 'Please select at least one grade level for this subject.',
            'grade_levels.array' => 'The grade levels field must be a valid list of selected items.',
            'grade_levels.min' => 'Select at least one grade level to continue.',
            'grade_levels.*.integer' => 'Each selected grade level must have a valid ID.',
            'grade_levels.*.exists' => 'One or more selected grade levels do not exist in the system.',
        ];
    }
}
