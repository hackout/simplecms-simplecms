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
        Schema::create('managers', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment("主键");
            $table->string('name')->comment("姓名");
            $table->string('account')->unique()->comment("登录账号");
            $table->string('email')->unique()->comment("密保邮箱");
            $table->timestamp('email_verified_at')->nullable()->comment("验证时间");
            $table->string('password')->comment("登录密码");
            $table->boolean('is_super')->default(false)->comment("是否超管");
            $table->boolean('is_valid')->default(false)->comment("是否启用");
            $table->timestamp('last_login')->nullable()->comment("最后登录时间");
            $table->ipAddress('last_ip')->nullable()->comment("最后访问IP");
            $table->integer('failed_count')->default(0)->comment("失败次数");
            $table->rememberToken();
            $table->timestamps();
            $table->comment("管理员表");
        });
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
