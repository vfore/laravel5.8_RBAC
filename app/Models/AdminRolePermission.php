<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRolePermission extends Model
{
    protected $table = 'admin_role_permissions';
    protected $fillable = [
        'admin_role_id', 'admin_permission_id'
    ];
    public $timestamps = false;
}
