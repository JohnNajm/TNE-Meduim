<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'visibility',
        'user_id',
        'category_id',
    ];



    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function comments()
    {
        return $this->HasMany('App\Models\Comment');
    }

    public function images()
    {
        return $this->HasMany('App\Models\Image');
    }
}
