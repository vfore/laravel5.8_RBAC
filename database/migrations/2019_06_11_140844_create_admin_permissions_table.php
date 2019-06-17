<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->comment('权限名称');
            $table->string('description', 191)->nullable()->comment('权限描述');
            $table->string('route', 191)->nullable()->comment('路由标识');
            $table->string('icon', 50)->nullable()->comment('图标');
            $table->integer('pid')->default(0)->comment('上级权限id');
            $table->string('path', 191)->default('0_')->comment('权限路径');
            $table->integer('level')->default(0)->comment('级别');
            $table->tinyInteger('type')->comment('类型，1 目录，2 菜单，3 按钮');
            $table->integer('sort')->default(50)->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permissions');
    }
}
