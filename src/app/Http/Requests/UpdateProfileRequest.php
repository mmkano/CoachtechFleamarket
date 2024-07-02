<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image',
            'credit_card_number' => 'nullable|string',
            'credit_card_expiration' => 'nullable|string',
            'credit_card_cvc' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
            'bank_branch_name' => 'nullable|string',
            'bank_branch_code' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'bank_account_type' => 'nullable|string',
            'bank_account_holder' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => '名前は文字列で入力してください。',
            'postal_code.string' => '郵便番号は文字列で入力してください。',
            'address.string' => '住所は文字列で入力してください。',
            'building_name.string' => '建物名は文字列で入力してください。',
            'credit_card_number.string' => 'カード番号は文字列で入力してください。',
            'credit_card_expiration.string' => '有効期限は文字列で入力してください。',
            'credit_card_cvc.string' => 'CVCは文字列で入力してください。',
            'bank_account_number.string' => '銀行口座番号は文字列で入力してください。',
            'bank_branch_name.string' => '支店名は文字列で入力してください。',
            'bank_branch_code.string' => '支店コードは文字列で入力してください。',
            'bank_name.string' => '銀行名は文字列で入力してください。',
            'bank_account_type.string' => '口座種別は文字列で入力してください。',
            'bank_account_holder.string' => '口座名義人は文字列で入力してください。',
        ];
    }
}
