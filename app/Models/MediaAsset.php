<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaAsset extends Model
{
    use HasTranslations, SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'height' => 'integer',
            'size' => 'integer',
            'sort_order' => 'integer',
            'width' => 'integer',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(MediaAssetTranslation::class);
    }

    public function places(): MorphToMany
    {
        return $this->morphedByMany(Place::class, 'mediaable');
    }

    public function accommodations(): MorphToMany
    {
        return $this->morphedByMany(Accommodation::class, 'mediaable');
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'mediaable');
    }
}
