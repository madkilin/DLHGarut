<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangePoint extends Model
{
    protected $fillable = [
        'user_id',
        'reward_id',
        'consume_point',
        'status',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id', 'id');
    }
}
