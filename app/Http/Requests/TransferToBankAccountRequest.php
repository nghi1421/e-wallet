<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferToBankAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number_source' => ['required','exists:users,phone_number'],
            'bank_account_des' => ['required'],
            'money' => ['required', 'numeric'],
            'bank_id' => ['required', 'exists:banks,id'],
            'note' => [ 'string'],
        ];
    }
}
