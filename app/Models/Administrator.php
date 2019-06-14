<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'administrators';
    protected $fillable = [
        'nickname', 'phone', 'email', 'status', 'password'
    ];
}
