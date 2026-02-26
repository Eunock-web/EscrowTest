<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'categrie_id',
        'description',
        'prix',
        'stock',
        'url_image'
    ];
}
