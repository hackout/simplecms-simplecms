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
        Schema::create('article_categories', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('主键');
            $table->uuid('parent_id')->nullable()->comment('父分类');
            $table->string('name')->comment('分类名称');
            $table->string('slug')->unique()->comment('分类标识');
            $table->string('description')->nullable()->comment('分类说明');
            $table->boolean('is_valid')->default(true)->comment('是否启用');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->timestamps();
            $table->comment('文章分类表');
        });

        Schema::create('article_tags', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('主键');
            $table->string('name')->comment('标签名称');
            $table->string('slug')->unique()->comment('标签标识');
            $table->string('description')->nullable()->comment('标签说明');
            $table->timestamps();
            $table->comment('文章标签表');
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('主键');
            $table->uuid('category_id')->nullable()->comment('分类ID');
            $table->string('title')->comment('文章标题');
            $table->string('slug')->unique()->comment('文章标识');
            $table->string('summary')->nullable()->comment('摘要');
            $table->longText('content')->nullable()->comment('正文');
            $table->text('review_note')->nullable()->comment('审核反馈');
            $table->string('cover')->nullable()->comment('封面');
            $table->uuid('author_id')->nullable()->comment('作者ID');
            $table->string('status')->default('draft')->comment('文章状态');
            $table->string('seo_title')->nullable()->comment('SEO标题');
            $table->string('seo_description')->nullable()->comment('SEO描述');
            $table->string('seo_keywords')->nullable()->comment('SEO关键词');
            $table->boolean('is_published')->default(false)->comment('是否发布');
            $table->boolean('is_top')->default(false)->comment('是否置顶');
            $table->boolean('is_recommended')->default(false)->comment('是否推荐');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->unsignedInteger('views')->default(0)->comment('浏览量');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
            $table->timestamps();
            $table->comment('文章表');
        });

        Schema::create('article_tag', function (Blueprint $table) {
            $table->uuid('article_id');
            $table->uuid('article_tag_id');
            $table->primary(['article_id', 'article_tag_id']);
            $table->timestamps();
            $table->comment('文章标签关联表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_tags');
        Schema::dropIfExists('article_categories');
    }
};
