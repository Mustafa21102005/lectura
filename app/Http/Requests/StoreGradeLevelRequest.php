<?php

namespace App\Http\Requests;

use App\Models\GradeLevel;
use Illuminate\Foundation\Http\FormRequest;

class StoreGradeLevelRequest extends FormRequest
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
            'number' => [
                'required',
                'integer',
                // Custom unique check on 'name' column in GradeLevel
                function ($attribute, $value, $fail) {
                    $name = "Grade " . $value;
                    if (GradeLevel::where('name', $name)->exists()) {
                        $fail("A grade with this number already exists.");
                    }
                },
            ],
        ];
    }

    /**
     * Custom validation messages for storing a grade level.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'number.required' => 'Please enter the grade level number.',
            'number.integer'  => 'The grade level number must be a valid whole number.'
        ];
    }
}
