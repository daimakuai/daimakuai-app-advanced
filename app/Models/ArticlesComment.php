<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticlesComment extends Model
{
    protected $table = 'demo_articles_comments';

    protected $fillable = ['content'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}