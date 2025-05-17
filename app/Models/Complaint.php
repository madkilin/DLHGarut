<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'latitude',
        'longitude',
        'kecamatan',
        'kabupaten',
        'full_address',
        'photos',
        'note',
        'video'
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignedUser()
{
    return $this->belongsTo(User::class, 'assigned_to');
}
public function proof()
{
    return $this->hasOne(Proof::class);
}
}
