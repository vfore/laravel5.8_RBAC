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
            $table->string('route', 191)->nullable()->comment('路由');
            $table->string('icon', 50)->nullable()->comment('图标');
            $table->integer('pid')->default(0)->comment('父id');
            $table->tinyInteger('type')->comment('类型，1 菜单，2 tab，3 按钮');
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
