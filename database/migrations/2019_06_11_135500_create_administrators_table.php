<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nickname', 191)->comment('昵称');
            $table->string('phone', 11)->unique()->comment('手机号');
            $table->string('email', 191)->unique()->comment('邮箱');
            $table->string('password', 191)->comment('密码');
            $table->tinyInteger('status')->default(1)->comment('状态：0 禁用，1 启用，2 已删除');
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
        Schema::dropIfExists('administrators');
    }
}
