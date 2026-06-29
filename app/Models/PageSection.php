<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageSection extends Model
{
    use HasTranslations, SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'settings' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PageSectionTranslation::class);
    }

    public function mediaAssets(): MorphToMany
    {
        return $this->morphToMany(MediaAsset::class, 'mediaable')
            ->withPivot(['collection', 'is_featured', 'sort_order'])
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }
}
