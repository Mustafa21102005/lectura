<?php

namespace App\Http\Requests;

use App\Models\GradeLevel;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeLevelRequest extends FormRequest
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
        $gradeId = $this->route('grade_level')->id ?? null;

        return [
            'number' => [
                'required',
                'integer',
                // Custom rule for uniqueness excluding current grade
                function ($attribute, $value, $fail) use ($gradeId) {
                    $name = "Grade " . $value;
                    if (GradeLevel::where('name', $name)
                        ->where('id', '!=', $gradeId)
                        ->exists()
                    ) {
                        $fail('A grade with this number already exists.');
                    }
                },
            ],
        ];
    }

    /**
     * Custom validation messages for updating a grade level.
     */
    public function messages(): array
    {
        return [
            'number.required' => 'Please enter the grade level number.',
            'number.integer'  => 'The grade level number must be a valid whole number.',
        ];
    }
}
