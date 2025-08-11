<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'name',
        'image',
        'point',
        'quota'
    ];

    public function exchangPoint()
    {
        return $this->hasMany(ExchangePoint::class, 'reward_id', 'id');
    }
}
