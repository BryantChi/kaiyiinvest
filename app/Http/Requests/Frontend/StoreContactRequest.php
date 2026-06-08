<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:5000',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('姓名'),
            'email' => __('電子郵件'),
            'phone' => __('聯絡電話'),
            'subject' => __('主旨'),
            'message' => __('訊息內容'),
        ];
    }
}
