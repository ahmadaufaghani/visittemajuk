<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelGuideTranslation extends Model
{
    protected $guarded = [];

    public function travelGuide(): BelongsTo
    {
        return $this->belongsTo(TravelGuide::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class, 'locale_code', 'code');
    }
}
