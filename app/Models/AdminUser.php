<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'admin_users';
    protected $fillable = [
        'nickname', 'phone', 'email', 'status', 'password'
    ];
}
