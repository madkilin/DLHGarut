<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressLog extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'value',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function action($user, $value, $type, $reference)
    {
        $text = $user->name . " Mendapatkan " . $value . " " . strtoupper($type) . " dari hasil " . $reference;
        self::create([
            'user_id' => $user->id,
            'type' => $type,
            'value' => $value,
            'description' => $text
        ]);
    }
}
