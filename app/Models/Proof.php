<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proof extends Model
{
      protected $fillable = ['complaint_id', 'description', 'officers', 'amount', 'unit', 'photos'];

    protected $casts = [
        'officers' => 'array',
        'photos' => 'array',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
