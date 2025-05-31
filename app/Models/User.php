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
}
