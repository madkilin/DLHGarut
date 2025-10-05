<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['level', 'required_exp'];

    protected $appends = [''];

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
            'platinum' => '💠',
            'diamond'  => '💎',
        };
    }
}
