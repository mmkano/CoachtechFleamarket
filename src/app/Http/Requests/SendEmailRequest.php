<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
{
    public function authorize()
    {
        // 必要に応じて認可ロジックを追加します。
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => '件名は必須です',
            'subject.string' => '件名は文字列である必要があります',
            'subject.max' => '件名は255文字以内である必要があります',
            'message.required' => 'メッセージは必須です',
            'message.string' => 'メッセージは文字列である必要があります',
        ];
    }
}
