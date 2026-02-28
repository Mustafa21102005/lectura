<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudyMaterialRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'unique:study_materials,title,' . $this->route('study_material')->id],
            'description' => ['nullable', 'string'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'material_type_id' => ['required', 'exists:material_types,id'],
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
     * Custom validation messages for updating study materials.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Title
            'title.required' => 'Please provide a title for the study material.',
            'title.string'   => 'The title must be valid text.',
            'title.max'      => 'The title may not exceed 255 characters.',
            'title.unique'   => 'A study material with this title already exists. Please choose a different title.',

            // Description
            'description.string' => 'The description must contain valid text.',

            // Subject
            'subject_id.required' => 'Please select the subject associated with this study material.',
            'subject_id.exists'   => 'The selected subject is invalid. Please choose an existing subject.',

            // Material Type
            'material_type_id.required' => 'Please select the type of material (e.g., PDF, Video, Notes).',
            'material_type_id.exists'   => 'The selected material type is invalid.',

            // File Uploads
            'file.*.file'  => 'Each uploaded item must be a valid file.',
            'file.*.mimes' => 'Only the following file types are allowed: JPG, JPEG, PNG, GIF, WEBP, BMP, SVG, PDF, MP4, WEBM, OGG, MOV, DOC, DOCX, XLS, XLSX, PPT, PPTX, WAV, MP3.',
            'file.*.max'   => 'Each file must not exceed 100 MB in size.',

            // Uploaded Files (FilePond JSON)
            'uploaded_files.string' => 'Uploaded file data must be a valid JSON string.',
        ];
    }
}
