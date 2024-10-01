<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloodreq extends Model
{
    use HasFactory;

    public function webuser()
    {
        return $this->belongsTo(Webuser::class);
    }

    protected $casts = [
        'blood_group_required' => 'array',
    ];
}
