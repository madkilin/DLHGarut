<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleUserRead extends Model
{
    protected $table = 'article_user_read';

    protected $fillable = [
        'user_id',
        'article_id',
        'read_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }
}
