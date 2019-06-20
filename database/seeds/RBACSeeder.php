<?php

use Illuminate\Database\Seeder;

class RBACSeeder extends Seeder
{

    private $admin;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->administrator();
        $this->adminRole();
        $this->administratorRole();
        $this->adminPermission($this->sidebar());
    }

    private function administrator()
    {
        $this->admin = \App\Models\Administrator::create([
            'nickname' => 'admin',
            'phone' => '13123456789',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        \App\Models\Administrator::create([
            'nickname' => 'test',
            'phone' => '13123456788',
            'email' => 'test@test.com',
            'password' => bcrypt('123456')
        ]);
    }

    private function adminRole()
    {
        \App\Models\AdminRole::create([
            'name' => '超级管理员',
            'description' => '具有至高无上的权利'
        ]);
    }

    private function administratorRole()
    {
        $role = \App\Models\AdminRole::find(1);
        $this->admin->assignRole($role);
    }

    private function adminPermission($sidebar)
    {
        foreach ($sidebar as $v) {
            \App\Models\AdminRolePermission::create([
                'admin_role_id' => 1,
                'admin_permission_id' => $v['id']
            ]);
            \App\Models\AdminPermission::create([
                'id' => $v['id'],
                'name' => $v['name'],
                'description' => $v['description'],
                'route' => $v['route'],
                'icon' => $v['icon'],
                'pid' => $v['pid'],
                'path' => $v['path'],
                'level' => $v['level'],
                'type' => $v['type'],
                'sort' => isset($v['sort']) ? $v['sort'] : 50
            ]);
            if (isset($v['children']) && !empty($v['children'])) {
                $this->adminPermission($v['children']);
            }
        }
    }

    private function sidebar()
    {
        return [
            [
                'id' => 1,
                'name' => '管理员管理',
                'description' => '',
                'route' => '',
                'icon' => '',
                'pid' => 0,
                'path' => '0_',
                'level' => 1,
                'type' => 1,
                'children' => [
                    [
                        'id' => 2,
                        'name' => '管理员列表',
                        'description' => '',
                        'route' => 'administrator.index',
                        'icon' => '',
                        'pid' => 1,
                        'path' => '0_1_',
                        'level' => 2,
                        'type' => 2,
                        'sort' => 55,
                        'children' => [
                            [
                                'id' => 3,
                                'name' => '添加管理员',
                                'description' => '',
                                'route' => 'administrator.create',
                                'icon' => '',
                                'pid' => 2,
                                'path' => '0_1_2_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 4,
                                'name' => '保存管理员',
                                'description' => '',
                                'route' => 'administrator.store',
                                'icon' => '',
                                'pid' => 2,
                                'path' => '0_1_2_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 5,
                                'name' => '编辑管理员',
                                'description' => '',
                                'route' => 'administrator.edit',
                                'icon' => '',
                                'pid' => 2,
                                'path' => '0_1_2_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 6,
                                'name' => '更新管理员',
                                'description' => '',
                                'route' => 'administrator.update',
                                'icon' => '',
                                'pid' => 2,
                                'path' => '0_1_2_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 7,
                                'name' => '删除管理员',
                                'description' => '',
                                'route' => 'administrator.destroy',
                                'icon' => '',
                                'pid' => 2,
                                'path' => '0_1_2_',
                                'level' => 3,
                                'type' => 3,
                            ],
                        ]
                    ],
                    [
                        'id' => 8,
                        'name' => '角色管理',
                        'description' => '',
                        'route' => 'role.index',
                        'icon' => '',
                        'pid' => 1,
                        'path' => '0_1_',
                        'level' => 2,
                        'type' => 2,
                        'sort' => 54,
                        'children' => [
                            [
                                'id' => 9,
                                'name' => '添加角色',
                                'description' => '',
                                'route' => 'role.create',
                                'icon' => '',
                                'pid' => 8,
                                'path' => '0_1_8_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 10,
                                'name' => '保存角色',
                                'description' => '',
                                'route' => 'role.store',
                                'icon' => '',
                                'pid' => 8,
                                'path' => '0_1_8_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 11,
                                'name' => '编辑角色',
                                'description' => '',
                                'route' => 'administrator.edit',
                                'icon' => '',
                                'pid' => 8,
                                'path' => '0_1_8_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 12,
                                'name' => '更新角色',
                                'description' => '',
                                'route' => 'role.update',
                                'icon' => '',
                                'pid' => 8,
                                'path' => '0_1_8_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 13,
                                'name' => '删除角色',
                                'description' => '',
                                'route' => 'role.destroy',
                                'icon' => '',
                                'pid' => 8,
                                'path' => '0_1_8_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 14,
                                'name' => '权限配置',
                                'description' => '',
                                'route' => 'role.permission',
                                'icon' => '',
                                'pid' => 8,
                                'path' => '0_1_8_',
                                'level' => 3,
                                'type' => 3,
                            ],
                        ]
                    ],
                    [
                        'id' => 15,
                        'name' => '权限管理',
                        'description' => '',
                        'route' => 'permission.index',
                        'icon' => '',
                        'pid' => 1,
                        'path' => '0_1_',
                        'level' => 2,
                        'type' => 2,
                        'children' => [
                            [
                                'id' => 16,
                                'name' => '添加权限',
                                'description' => '',
                                'route' => 'permission.create',
                                'icon' => '',
                                'pid' => 15,
                                'path' => '0_1_15_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 17,
                                'name' => '保存权限',
                                'description' => '',
                                'route' => 'permission.store',
                                'icon' => '',
                                'pid' => 15,
                                'path' => '0_1_15_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 18,
                                'name' => '编辑权限',
                                'description' => '',
                                'route' => 'administrator.edit',
                                'icon' => '',
                                'pid' => 15,
                                'path' => '0_1_15_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 19,
                                'name' => '更新权限',
                                'description' => '',
                                'route' => 'permission.update',
                                'icon' => '',
                                'pid' => 15,
                                'path' => '0_1_15_',
                                'level' => 3,
                                'type' => 3,
                            ],
                            [
                                'id' => 20,
                                'name' => '删除权限',
                                'description' => '',
                                'route' => 'permission.destroy',
                                'icon' => '',
                                'pid' => 15,
                                'path' => '0_1_15_',
                                'level' => 3,
                                'type' => 3,
                            ]
                        ]
                    ],
                ]
            ],
        ];
    }
}
