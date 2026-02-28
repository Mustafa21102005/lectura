<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialTypeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:material_types,name'],
        ];
    }

    /**
     * Custom validation messages for storing material types.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide a name for the material type.',
            'name.string'   => 'The material type name must be a valid text string.',
            'name.max'      => 'The material type name may not exceed 255 characters.',
            'name.unique'   => 'This material type already exists. Please choose a different type.',
        ];
    }
}
