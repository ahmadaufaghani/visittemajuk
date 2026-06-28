<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavigationItemTranslation extends Model
{
    protected $guarded = [];

    public function navigationItem(): BelongsTo
    {
        return $this->belongsTo(NavigationItem::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class, 'locale_code', 'code');
    }
}
