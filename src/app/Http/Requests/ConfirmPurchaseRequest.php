<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPurchaseRequest extends FormRequest
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
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'postal_code.required' => '郵便番号を登録してください',
            'address.required' => '住所を登録してください',
            'payment_method.required' => '支払い方法を選択してください',
        ];
    }
}
