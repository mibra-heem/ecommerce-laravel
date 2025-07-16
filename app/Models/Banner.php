<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Banner extends Model

{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'is_active',
        'order',
    ];

}
