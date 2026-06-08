<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Faq extends Model
{
    protected $fillable = [
        'category',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class);
    }

    /**
     * 指定語系的翻譯（無則 fallback 預設語系，再 fallback 任一筆）。
     */
    public function translation(?string $locale = null): ?FaqTranslation
    {
        $locale = $locale ?: app()->getLocale();

        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', \App\Support\LocaleService::default())
            ?? $this->translations->first();
    }

    public function translationFor(string $locale): ?FaqTranslation
    {
        return $this->translations->firstWhere('locale', $locale);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('order')->orderBy('id');
    }
}
