<?php

namespace App\Models\Concerns;

use App\Models\Locale;
use Illuminate\Database\Eloquent\Model;

trait HasTranslations
{
    public function translation(?string $locale = null, bool $fallback = true): ?Model
    {
        $locale ??= app()->getLocale();
        $fallbackLocale = Locale::defaultCode();

        if ($this->relationLoaded('translations')) {
            $translations = $this->getRelation('translations');

            return $translations->firstWhere('locale_code', $locale)
                ?? ($fallback ? $translations->firstWhere('locale_code', $fallbackLocale) : null);
        }

        $translation = $this->translations()->where('locale_code', $locale)->first();

        if ($translation || ! $fallback || $locale === $fallbackLocale) {
            return $translation;
        }

        return $this->translations()->where('locale_code', $fallbackLocale)->first();
    }

    public function title(?string $locale = null): string
    {
        $translation = $this->translation($locale);

        return (string) ($translation?->getAttribute('title')
            ?? $translation?->getAttribute('name')
            ?? $translation?->getAttribute('label')
            ?? '');
    }
}
