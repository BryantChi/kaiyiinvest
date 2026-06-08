<?php

/*
| 繁體中文驗證訊息（預設語系）。僅含常用規則；其餘 fallback 至內建英文。
*/

return [
    'required' => ':attribute 為必填欄位。',
    'email' => ':attribute 必須是有效的電子郵件地址。',
    'string' => ':attribute 必須是文字。',
    'integer' => ':attribute 必須是整數。',
    'array' => ':attribute 格式不正確。',
    'max' => [
        'string' => ':attribute 不可超過 :max 個字元。',
        'numeric' => ':attribute 不可大於 :max。',
        'array' => ':attribute 最多 :max 個項目。',
    ],
    'min' => [
        'string' => ':attribute 至少需 :min 個字元。',
    ],
    'unique' => ':attribute 已被使用。',
    'confirmed' => ':attribute 與確認欄位不符。',

    'attributes' => [],
    'custom' => [],
];
