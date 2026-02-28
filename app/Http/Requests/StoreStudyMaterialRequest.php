<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudyMaterialRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'unique:study_materials,title'],
            'description' => ['nullable', 'string'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'material_type_id' => ['required', 'exists:material_types,id'],
            'uploaded_files' => ['nullable', 'string'], // JSON from FilePond
        ];
    }

    /**
     * Custom validation messages for storing study materials.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Title
            'title.required' => 'Please enter a title for the study material.',
            'title.string'   => 'The title must be a valid text string.',
            'title.max'      => 'The title must not exceed 255 characters.',
            'title.unique'   => 'A study material with this title already exists. Please choose a different title.',

            // Description
            'description.string' => 'The description must be valid text.',

            // Subject
            'subject_id.required' => 'Please select a subject for this study material.',
            'subject_id.exists'   => 'The selected subject does not exist. Please choose a valid subject.',

            // Material Type
            'material_type_id.required' => 'Please select the material type (e.g., PDF, Video, Notes).',
            'material_type_id.exists'   => 'The selected material type is invalid. Please choose a valid option.',

            // Files
            'uploaded_files.string' => 'The uploaded files data must be valid.',
        ];
    }
}
