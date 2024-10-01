<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'blood_group',
    ];

    public function webuser()
    {
        return $this->belongsTo(Webuser::class);
    }
}
