<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Locale $locale): void {
            if (! $locale->is_default) {
                return;
            }

            static::query()
                ->whereKeyNot($locale->getKey())
                ->update(['is_default' => false]);
        });
    }

    public static function defaultCode(): string
    {
        return (string) (static::query()
            ->where('is_default', true)
            ->value('code') ?? config('app.fallback_locale', 'id'));
    }

    public static function activeCodes(): array
    {
        $databaseLocales = static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->pluck('code')
            ->all();

        return $databaseLocales ?: config('app.supported_locales', [config('app.locale', 'id')]);
    }
}
