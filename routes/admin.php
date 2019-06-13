<?php

/*
 * 后台路由文件
*/

Route::get('/index', function () {
    return view('admin.layout.layout');
})->name('admin_index');

Route::get('/adminUser', function () {
    return view('admin.admin_user.list');
});

Route::get('/adminUser/create', function () {
    return view('admin.admin_user.create');
});