<?php
/*
 * 后台路由文件
*/

Route::get('/index', function () {
    return view('admin.layout.layout');
})->name('admin_index');

Route::group(['namespace' => 'Admin'], function () {
    Route::resource('adminUser', 'AdminUserController');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
});

