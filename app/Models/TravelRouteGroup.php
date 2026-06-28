<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelRouteGroup extends Model
{
    use HasTranslations, SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function travelGuide(): BelongsTo
    {
        return $this->belongsTo(TravelGuide::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(TravelRouteGroupTranslation::class);
    }

    public function routes(): HasMany
    {
        return $this->hasMany(TravelRoute::class)->orderBy('sort_order');
    }
}
