<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmissionRequest extends FormRequest
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
            'remarks' => ['nullable', 'string'],
            'file.*' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,gif,webp,bmp,svg,pdf,mp4,webm,ogg,mov',
                'max:102400',
            ],
            'uploaded_files' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom validation messages for updating a submission.
     *
     * @return array<string, string>
     *
     * Contains custom error messages for the validation rules defined in the rules method.
     */
    public function messages(): array
    {
        return [
            // Remarks
            'remarks.string' => 'Remarks must be written as text.',

            // Files
            'file.*.file' => 'Each uploaded item must be a valid file.', // e.g. image, document, video
            'file.*.mimes' => 'Unsupported file type detected. Allowed types: jpg, jpeg, png, gif, webp, bmp, svg, pdf, mp4, webm, ogg, mov.',
            'file.*.max' => 'Each file must not exceed 100MB in size.',

            'uploaded_files.string' => 'Uploaded files data must be a valid JSON string.',
        ];
    }
}
