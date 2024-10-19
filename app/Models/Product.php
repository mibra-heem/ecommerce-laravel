<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use HasFactory;


    protected $keyType = 'string'; // Set the key type to string
    public $incrementing = false;  // Disable auto-incrementing

    protected $fillable = [
        'id',
        'name',
        'category',
        'image',
        'descr',
        'rating',
        'brand'
    ];

    private static $lastId = null;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Ensure the product has a unique alphanumeric ID
            $product->id = self::generateAlphanumericId();
        });
    }

    protected static function generateAlphanumericId(): string
    {
        if (self::$lastId === null) {
            // Start with the last record in the database if no ID is set
            $lastProduct = self::orderBy('id', 'desc')->first();
            $lastNumber = $lastProduct ? (int)substr($lastProduct->id, 3) : 0;
            self::$lastId = $lastNumber;
        }

        // Increment the last ID for each new product
        self::$lastId++;

        // Format the new ID with the 'PD-' prefix and zero-padding
        $prefix = 'PD-';
        return $prefix . str_pad(self::$lastId, 5, '0', STR_PAD_LEFT);
    }

}
