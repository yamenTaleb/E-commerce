<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'description',
        'category_parent_id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_parent_id');
    }

    public function childrenCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'category_parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
