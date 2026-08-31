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
        Schema::create('article_versions', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('版本主键');
            $table->uuid('article_id')->comment('文章ID');
            $table->uuid('category_id')->nullable()->comment('分类ID');
            $table->string('title')->comment('版本标题');
            $table->string('slug')->comment('版本标识');
            $table->string('summary')->nullable()->comment('版本摘要');
            $table->longText('content')->nullable()->comment('版本正文');
            $table->text('review_note')->nullable()->comment('审核反馈');
            $table->string('cover')->nullable()->comment('封面');
            $table->uuid('author_id')->nullable()->comment('作者ID');
            $table->string('status')->default('draft')->comment('版本状态');
            $table->string('seo_title')->nullable()->comment('SEO标题');
            $table->string('seo_description')->nullable()->comment('SEO描述');
            $table->string('seo_keywords')->nullable()->comment('SEO关键词');
            $table->boolean('is_published')->default(false)->comment('是否发布');
            $table->boolean('is_top')->default(false)->comment('是否置顶');
            $table->boolean('is_recommended')->default(false)->comment('是否推荐');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->unsignedInteger('views')->default(0)->comment('浏览量');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
            $table->unsignedInteger('version_number')->default(1)->comment('版本号');
            $table->timestamps();
            $table->comment('文章版本表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_versions');
    }
};
