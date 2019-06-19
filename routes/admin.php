<?php
/*
 * 后台路由文件
*/



Route::group(['namespace' => 'Admin'], function () {
    // 登录
    Route::get('login', 'LoginController@index')->name('admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login');
    Route::get('logout', 'LoginController@logout')->name('admin.logout');
});

Route::group(['namespace' => 'Admin', 'middleware' => 'permissionAuth'], function () {

    Route::get('/index', 'IndexController@index')->name('admin.index');
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
