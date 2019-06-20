<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_roles';
    protected $fillable = [
        'name', 'description', 'sort'
    ];

    /**
     * 角色与权限多对多关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, 'admin_role_permissions', 'admin_role_id', 'admin_permission_id')->orderBy('admin_permissions.sort', 'desc');
//        return $this->belongsToMany(AdminPermission::class, 'admin_role_permission', 'admin_role_id', 'admin_permission_id')->withPivot(['admin_role_id', 'admin_permission_id']);
    }

    /**
     * 给角色赋予权限
     * @param int $permission 权限id
     * @return Model
     */
    public function grantPermission($permission)
    {
        return $this->permissions()->save($permission);
    }

    /**
     * 取消角色赋予的权限
     * @param int $permission
     * @return int
     */
    public function deletePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    /**
     * 判断角色是否有权限
     * @param $permission
     * @return mixed
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->contains($permission);
    }
}
