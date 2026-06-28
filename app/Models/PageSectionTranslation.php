<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSectionTranslation extends Model
{
    protected $guarded = [];

    public function pageSection(): BelongsTo
    {
        return $this->belongsTo(PageSection::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class, 'locale_code', 'code');
    }
}
