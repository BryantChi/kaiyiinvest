<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'locale',
        'ip',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function scopeUnread(Builder $query): void
    {
        $query->where('is_read', false);
    }
}
