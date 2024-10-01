<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloodcamps extends Model
{
    use HasFactory;
    protected $casts = [
        'participants' => 'array',
    ];
}
