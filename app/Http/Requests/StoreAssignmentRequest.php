<?php

namespace App\Http\Requests;

use App\Models\{GradeLevel, Subject};
use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'unique:assignments,title'],
            'description' => ['nullable', 'string'],
            'uploaded_files' => ['nullable', 'string'],
            'subject_grade' => ['required', function ($attribute, $value, $fail) {
                $parts = explode('_', $value);
                if (count($parts) !== 2) {
                    return $fail('The selected subject is invalid.');
                }
                [$subjectId, $gradeLevelId] = $parts;

                if (!Subject::where('id', $subjectId)->exists()) {
                    return $fail('The selected subject does not exist.');
                }

                if (!GradeLevel::where('id', $gradeLevelId)->exists()) {
                    return $fail('The selected grade level does not exist.');
                }
            }],
            'due_date' => ['required', 'after:now'],
            'max_score' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * Custom validation messages for storing assignments.
     */
    public function messages(): array
    {
        return [
            // Title
            'title.required' => 'Please provide a title for the assignment.',
            'title.string'   => 'The title must be valid text.',
            'title.max'      => 'The title may not exceed 255 characters.',
            'title.unique'   => 'An assignment with this title already exists.',

            // Description
            'description.string' => 'The description must contain valid text.',

            // Uploaded Files
            'uploaded_files.string' => 'Uploaded file data must be a valid JSON string.',

            // Subject
            'subject_grade.required' => 'Please select a subject and grade level for this assignment.',

            // Due Date
            'due_date.required' => 'Please provide a due date for the assignment.',
            'due_date.after'    => 'The due date must be a future date.',

            // Max Score
            'max_score.required' => 'Please specify the maximum mark for this assignment.',
            'max_score.integer'  => 'The maximum mark must be a whole number.',
            'max_score.min'      => 'The maximum mark must be at least 1 mark.',
            'max_score.max'      => 'The maximum mark cannot exceed 100 marks.'
        ];
    }
}
