<?php

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
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
        $submission = Submission::find($this->submission_id);

        $maxScore = $submission ? $submission->assignment->max_score : 0;

        return [
            'submission_id' => 'required|exists:submissions,id|unique:grades,submission_id',
            'score' => 'required|integer|min:0|max:' . $maxScore,
            'remarks' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'submission_id.required' => 'You need to select a submission before grading.',
            'submission_id.exists' => 'This submission doesn’t exist. Please check and try again.',
            'submission_id.unique' => 'This submission has already been graded.',
            'score.required' => 'Please enter a score for this submission.',
            'score.integer' => 'Score must be a number. Decimals are not allowed.',
            'score.min' => 'Score cannot be less than 0.',
            'score.max' => 'Score cannot exceed the maximum allowed: ' . optional($this->submission?->assignment)->max_score,
            'remarks.string' => 'Remarks should be text.',
        ];
    }
}
