<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurriculumRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:curricula,name,' . $this->curriculum->id
        ];
    }

    /**
     * Get the validation messages that apply to the rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Please provide a curriculum name before saving your changes.',
            'name.string' => 'The curriculum name must contain valid text.',
            'name.max' => 'The curriculum name is too long — please keep it under 255 characters.',
            'name.unique' => 'A curriculum with this name already exists. Please choose a different name.',
        ];
    }
}
