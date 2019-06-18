<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'administrators';
    protected $fillable = [
        'nickname', 'phone', 'email', 'status', 'password'
    ];

    /**
     * 管理员角色多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'administrator_roles', 'administrator_id', 'admin_role_id');
    }

    /**
     * 用户分配角色
     * @param $role
     * @return Model
     */
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    /**
     * 取消用户分配的角色
     * @param $role
     * @return int
     */
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }
}
