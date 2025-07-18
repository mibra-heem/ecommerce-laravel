<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'is_approved',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($review) {
            if ($review->is_approved) {
                $review->product->updateRating();
            }
        });

        static::updated(function ($review) {
            if ($review->is_approved || $review->getOriginal('is_approved')) {
                $review->product->updateRating();
            }
        });

        static::deleted(function ($review) {
            if ($review->is_approved) {
                $review->product->updateRating();
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
