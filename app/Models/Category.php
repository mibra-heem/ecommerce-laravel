<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'image',
        'name',
    ];


    protected function products(){
        return $this->hasMany(Product::class);
    }

    protected function banners(){
        return $this->hasMany(Banner::class);
    }
}
