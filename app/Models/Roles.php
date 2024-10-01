<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    public function webusers()
    {
        return $this->belongsToMany(Webuser::class, 'webusers_has_roles', 'webusers_id', 'roles_id');
    }
}
