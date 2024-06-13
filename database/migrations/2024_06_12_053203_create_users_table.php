<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment("主键");
            $table->string('uid')->unique()->comment("暴露UID");
            $table->string("nickname")->comment("昵称");
            $table->string("password")->comment("登录密码");
            $table->boolean('is_valid')->default(false)->comment("是否启用");
            $table->timestamp('last_login')->nullable()->comment("最后登录时间");
            $table->ipAddress('last_ip')->nullable()->comment("最后访问IP");
            $table->integer('failed_count')->default(0)->comment("失败次数");
            $table->ipAddress('register_ip')->nullable()->comment("注册IP");
            $table->string('register_finger')->nullable()->comment("注册指纹");
            $table->timestamps();
            $table->comment = "用户信息表";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
