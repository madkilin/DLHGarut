<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Level;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'exp',
        'level',
        'points',
        'nik',
        'phone',
        'address',
        'profile_photo',
        'status',
        'role_id',
        'note',
        'is_read_by_admin'
    ];

    protected $appends = ['avatar', 'leadeboard'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function readArticles()
    {
        return $this->belongsToMany(Article::class, 'article_user_read')
            ->withPivot('read_at')
            ->withTimestamps();
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function currentLevel()
    {
        return $this->belongsTo(Level::class, 'level', 'level');
    }

    public function addExp(int $expGained)
    {
        $this->exp += $expGained;

        while (true) {
            $current = Level::where('level', $this->level)->first();

            if (!$current || $this->exp < $current->required_exp) {
                break;
            }

            $this->exp -= $current->required_exp;
            $this->level += 1;
            $this->points += 10; // Optional: reward per level-up
        }

        $this->save();
    }

    public function article()
    {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    public function getCurrentLevelAttribute()
    {
        return Level::where('required_exp', '<=', $this->exp)
            ->orderByDesc('required_exp')
            ->value('level') ?? 1;
    }

    public function getTierAttribute()
    {
        $level = $this->current_level;

        return match (true) {
            $level >= 15 => 'diamond',
            $level >= 10 => 'platinum',
            $level >= 5  => 'gold',
            $level >= 3  => 'silver',
            default      => 'bronze',
        };
    }

    public function getTierBorderClassAttribute()
    {
        return match ($this->tier) {
            'bronze'   => 'tier-bronze',
            'silver'   => 'tier-silver',
            'gold'     => 'tier-gold',
            'platinum' => 'tier-platinum',
            'diamond'  => 'tier-diamond',
        };
    }

    public function getTierIconAttribute()
    {
        return match ($this->tier) {
            'bronze'   => '🥉',
            'silver'   => '🥈',
            'gold'     => '🥇',
            'platinum' => '🏆',
            'diamond'  => '💎',
        };
    }

    public function readArticle()
    {
        return $this->hasMany(ArticleUserRead::class, 'user_id', 'id');
    }

    public function exchangPoint()
    {
        return $this->hasMany(ExchangePoint::class, 'user_id', 'id');
    }

    public function getAvatarAttribute()
    {
        if ($this->profile_photo !== null) {
            return 'storage/profile_photos/' . $this->profile_photo;
        } else {
            return 'default_image/default_profile.png';
        }
    }

    public function getLeaderboardAttribute()
    {
        if ($this->role_id == 3) {
            $ranking = User::where('role_id', 3)->orderByDesc('exp')->pluck('id')->toArray();
            return array_search($this->id, $ranking) + 1;
        } else {
            return '#';
        }
    }

    public function progressLog()
    {
        return $this->hasMany(ProgressLog::class, 'user_id', 'id');
    }
}
