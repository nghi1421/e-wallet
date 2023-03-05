<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositMoneyRequest extends FormRequest
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
            "linked_id" => ['required', 'exists:linked,id'],
            "money" => ["required", 'numeric'],
            "phone_number_des" => ["required"],
            "note" => ['string']
        ];
    }
}
