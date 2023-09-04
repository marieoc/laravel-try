<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    // use an arbitrary name
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
