<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
}
