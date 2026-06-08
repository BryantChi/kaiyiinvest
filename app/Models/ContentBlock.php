<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = [
        'page',
        'key',
        'locale',
        'type',
        'value',
    ];

    protected static function booted(): void
    {
        // 內容異動清除 cb() 的請求外快取
        $clear = fn () => \App\Support\Content::flush();
        static::saved($clear);
        static::deleted($clear);
    }
}
