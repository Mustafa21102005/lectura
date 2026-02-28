<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'unique:assignments,title,' . $this->route('assignment')->id],
            'description' => ['nullable', 'string'],
            'subject_grade' => ['required', 'regex:/^\d+_\d+$/'], // matches "subjectId_gradeLevelId"
            'due_date' => ['required', 'after:now'],
            'max_score' => ['required', 'integer', 'min:1', 'max:100'],
            'file.*' => [
                'nullable',
                'file',
                'mimes:jpg,doc,docx,xls,ppt,jpeg,xlsx,wav,png,mp3,gif,webp,pptx,bmp,svg,pdf,mp4,webm,ogg,mov',
                'max:102400',
            ],
            'uploaded_files' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom validation messages for updating an assignment.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The assignment title is required.',
            'title.string' => 'The assignment title must be a valid string.',
            'title.max' => 'The assignment title cannot exceed 255 characters.',
            'title.unique' => 'An assignment with this title already exists.',

            'description.string' => 'The description must be a valid text.',

            'subject_grade.required' => 'Please select a subject and grade level for this assignment.',
            'subject_grade.regex' => 'Invalid subject/grade selection.',

            'due_date.required' => 'Please specify a due date for the assignment.',
            'due_date.after' => 'The due date must be a future date and time.',

            'max_score.required' => 'Please enter the maximum mark for this assignment.',
            'max_score.integer' => 'The maximum mark must be a valid integer.',
            'max_score.min' => 'The maximum mark must be at least 1.',
            'max_score.max' => 'The maximum mark cannot exceed 100.',

            'file.*.file' => 'Each uploaded file must be a valid file.',
            'file.*.mimes' => 'Only the following file types are allowed: JPG, JPEG, PNG, GIF, WEBP, BMP, SVG, PDF, MP4, WEBM, OGG, MOV, DOC, DOCX, XLS, XLSX, PPT, PPTX, WAV, MP3.',
            'file.*.max' => 'Each file cannot exceed 100 MB.',

            'uploaded_files.string' => 'Invalid uploaded files data.',
        ];
    }
}
