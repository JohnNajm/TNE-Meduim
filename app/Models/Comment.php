<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'user_id',
        'listing_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function listing()
    {
        return $this->belongsTo('App\Models\Listing');
    }
}
