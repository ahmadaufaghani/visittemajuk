<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelRouteGroupTranslation extends Model
{
    protected $guarded = [];

    public function travelRouteGroup(): BelongsTo
    {
        return $this->belongsTo(TravelRouteGroup::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class, 'locale_code', 'code');
    }
}
