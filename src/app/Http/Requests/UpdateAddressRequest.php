<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'building_name' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.string' => '郵便番号は正しく入力してください',
            'postal_code.max' => '郵便番号は10文字以内でお願いします',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は正しく入力してください',
            'address.max' => '住所は255文字以内でお願いします',
            'building_name.string' => '建物名は正しく入力してください',
            'building_name.max' => '建物名は255文字以内でお願いします',
        ];
    }
}
