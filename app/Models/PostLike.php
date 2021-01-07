<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PostLike extends Model
{
    protected $table = 'post_likes';

    protected $fillable = [
        'isLike',
        'post_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
