<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'sku',
        'price',
        'discount_price',
        'brand',
        'weight',
        'dimensions',
        'description',
        'rating',
        'is_active',
        'is_featured',
        'stock_status',
        'stock_quantity',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
        if (empty($this->attributes['sku'])) {
            $this->attributes['sku'] = Str::upper(Str::slug($value)) . '-' . Str::random(4);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            DB::transaction(function () use ($product) {
                $originalSlug = $product->slug;
                $count = 1;
                while (static::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
                    $product->slug = $originalSlug . '-' . $count++;
                }

                if ($product->stock_quantity <= 0) {
                    $product->stock_status = 'out_of_stock';
                } elseif ($product->stock_quantity <= 10) {
                    $product->stock_status = 'low_stock';
                } else {
                    $product->stock_status = 'in_stock';
                }
            });
        });

        static::creating(function ($product) {
            $product->id = static::generateAlphanumericId();
        });
    }

    protected static function generateAlphanumericId(): string
    {
        return DB::transaction(function () {
            $lastProduct = DB::table('products')->orderBy('id', 'desc')->lockForUpdate()->first();
            $lastNumber = $lastProduct ? (int) substr($lastProduct->id, 3) : 0;
            $newNumber = $lastNumber + 1;
            return 'PD-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function updateRating()
    {
        $avgRating = $this->reviews()->where('is_approved', true)->avg('rating') ?? 0.0;
        $this->rating = round($avgRating, 1);
        $this->save();
    }
}