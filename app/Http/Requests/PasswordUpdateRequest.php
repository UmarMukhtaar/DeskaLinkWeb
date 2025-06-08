<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    // ->letters()
                    // ->mixedCase()
                    // ->numbers()
                    // ->symbols()
                    // ->uncompromised(),
            ],
        ];
    }

    public function messages()
    {
        return [
            'current_password.current_password' => 'Password saat ini tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}