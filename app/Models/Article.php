<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'banner',
        'description',
        'user_id',
        'is_read_by_admin',
        'video',
        'alasan_penolakan',
        'confirmed_at'
    ];

    /**
     * Relasi: Artikel dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set slug otomatis dari title jika belum ada.
     */
    protected static function booted()
    {
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = \Str::slug($article->title);
            }
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function read()
    {
        return $this->hasMany(ArticleUserRead::class, 'article_id', 'id');
    }
}
