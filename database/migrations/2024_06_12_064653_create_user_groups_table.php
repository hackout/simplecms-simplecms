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
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("名称");
            $table->string("description")->nullable()->comment("会员组说明");
            $table->json("extra")->nullable()->comment("附加参数");
            $table->boolean("is_default")->default(false)->comment("是否默认");
            $table->integer("sort_order")->default(0)->comment("排序");
            $table->timestamps();
            $table->comment("会员组信息表");
        });
        Schema::create('users_groups', function (Blueprint $table) {
            $table->integer('user_group_id')->comment("会员组ID");
            $table->uuid('user_id')->comment("用户ID");
            $table->timestamp('valid_at')->nullable()->comment('过期时间');
            $table->primary(['user_id','user_group_id'],'user_group');
            $table->comment("会员关联表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_groups');
        Schema::dropIfExists('users_groups');
    }
};
