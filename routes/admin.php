<?php
/*
 * 后台路由文件
*/

Route::get('/index', function () {
    return view('admin.layout.layout');
})->name('admin_index');

Route::group(['namespace' => 'Admin'], function () {
    // 管理员管理
    Route::resource('administrator', 'AdministratorController');
    // 角色管理
    Route::resource('role', 'RoleController');
    // 角色权限配置
    Route::get('role/{role}/permission', 'RoleController@permission')->name('role.permission');
    Route::post('role/{role}/permission', 'RoleController@permissionConfiguration')->name('role.permission');
    // 权限管理
    Route::resource('permission', 'PermissionController');
});

