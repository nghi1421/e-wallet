<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => [
                'required',
                'max:15',
                'regex:/(0)[0-9]/',
                'not_regex:/[a-z]/',
                'min: 9',
                'unique:users,phone_number'
            ],
            'password' => [
                'required',
                'max:50',
                'confirmed',
                Password::min(8)->max(50)->mixedCase()->numbers()->symbols(),
            ],
            'name' => [
                'required',
                'max:50',
            ],
            'dob' => [
                'date',
            ],
            'address' => [
                'string',
                'max:100',
            ],
        ];
    }
}
