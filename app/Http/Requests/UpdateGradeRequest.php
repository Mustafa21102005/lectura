<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
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
        $grade = $this->route('grade');
        $submission = $grade ? $grade->submission : null;

        $maxScore = $submission ? $submission->assignment->max_score : 0;

        return [
            'score' => 'required|integer|min:0|max:' . $maxScore,
            'remarks' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'score.required' => 'Please enter a score before updating the grade.',
            'score.integer' => 'The score must be a valid whole number.',
            'score.min' => 'The score cannot be less than 0.',
            'score.max' => 'The score cannot exceed the maximum allowed for this assignment.',
            'remarks.string' => 'Remarks must be written as text.',
        ];
    }
}
