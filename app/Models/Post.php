<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Sluggable;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'photo',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class,'post_id','id')
                    ->where('status',true);
    }

    /**
     * The post likes that belong to the user.
     */
    // public function likes()
    // {
    //     return $this->belongsToMany(PostLike::class,
    //         'post_likes',
    //         'post_id',
    //         'user_id',
    //         'id');
    // }

    public function likes(){
        return $this->belongsTo(PostLike::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
