<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9+\-\s()]*$/', // allows numbers, spaces, dashes, parentheses, +
                'min:8',
                'max:20',
                Rule::unique(User::class)->ignore($this->user()->id), // unique phone per user
            ]
        ];
    }

    /**
     * Custom validation messages for updating user profile.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Name
            'name.required' => 'Please enter your full name.',
            'name.string'   => 'Your name must contain valid characters.',
            'name.max'      => 'Your name may not exceed 255 characters.',

            // Email
            'email.required' => 'Please provide your email address.',
            'email.string'   => 'The email must be a valid text string.',
            'email.lowercase' => 'Your email address must be in lowercase.',
            'email.email'    => 'Please enter a valid email address (e.g., name@example.com).',
            'email.max'      => 'Your email address may not exceed 255 characters.',
            'email.unique'   => 'This email address is already in use. Please use a different one.',

            // Phone
            'phone.required' => 'Please provide your phone number.',
            'phone.string'   => 'The phone number must contain valid characters.',
            'phone.regex'    => 'Your phone number may only include numbers, spaces, parentheses, dashes, or the plus sign (+).',
            'phone.min'      => 'The phone number must be at least 8 characters long.',
            'phone.max'      => 'The phone number must not exceed 20 characters.',
            'phone.unique'   => 'This phone number is already associated with another account.',
        ];
    }
}
