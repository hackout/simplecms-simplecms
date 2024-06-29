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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('user_id')->primary()->comment("用户ID");
            $table->string("name")->nullable()->comment("姓名");
            $table->date("birth_date")->nullable()->comment("生日");
            $table->string("emergency_contact")->nullable()->comment("应急联系人");
            $table->string("emergency_phone")->nullable()->comment("应急电话");
            $table->string("emergency_address")->nullable()->comment("应急地址");
            $table->timestamps();
            $table->comment("用户信息表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
