<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $table = 'admin_permissions';
    protected $fillable = [
        'name', 'route', 'type', 'sort', 'pid', 'icon','level','description', 'path'
    ];
}
