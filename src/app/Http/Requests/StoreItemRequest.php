<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'img_url' => 'required|image',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_item_id' => 'required|integer',
            'condition_id' => 'required|integer',
            'brand_id' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'img_url.required' => '商品画像を選択してください',
            'img_url.image' => '有効な画像ファイルをアップロードしてください',
            'name.required' => '商品名を入力してください',
            'name.string' => '商品名は文字で入力してください',
            'name.max' => '商品名は255文字以内で入力してください',
            'price.required' => '価格を入力してください',
            'price.numeric' => '価格は数値で入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.string' => '商品の説明は文字で入力してください',
            'category_item_id.required' => 'カテゴリを選択してください',
            'category_item_id.integer' => 'カテゴリは有効な値を選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'condition_id.integer' => '商品の状態は有効な値を選択してください',
            'brand_id.integer' => 'ブランドは有効な値を選択してください',
        ];
    }
}
