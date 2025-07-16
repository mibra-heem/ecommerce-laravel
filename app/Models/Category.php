<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'icon_url',
        'description',
        'is_active',
        'order',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        // Generate slug from name if not provided
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // Ensure slug uniqueness
    public static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            $originalSlug = $category->slug;
            $count = 1;
            while (static::where('slug', $category->slug)->where('id', '!=', $category->id)->exists()) {
                $category->slug = $originalSlug . '-' . $count++;
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

}