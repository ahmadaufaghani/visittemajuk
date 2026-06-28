<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaAssetTranslation extends Model
{
    protected $guarded = [];

    public function mediaAsset(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class);
    }

    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class, 'locale_code', 'code');
    }
}
