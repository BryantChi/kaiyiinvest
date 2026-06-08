<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $fillable = [
        'code',
        'name',
        'native_name',
        'is_default',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        // 任何異動清除 LocaleService 快取
        $clear = fn () => \App\Support\LocaleService::clearCache();
        static::saved($clear);
        static::deleted($clear);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }
}
