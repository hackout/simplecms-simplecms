<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('account')->primary()->comment("账号主键");
            $table->foreignUuid('user_id')->nullable()->comment("用户ID");
            $table->integer('type')->default(0)->comment("账号类型");
            $table->string('oauth_id')->nullable()->comment("OAuthID");
            $table->boolean('is_valid')->default(false)->comment("是否启用");
            $table->timestamp('last_login')->nullable()->comment("最后登录时间");
            $table->ipAddress('last_ip')->nullable()->comment("最后访问IP");
            $table->json('extra')->nullable()->comment("附加信息");
            $table->timestamps();
            $table->comment = "账号信息表";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
