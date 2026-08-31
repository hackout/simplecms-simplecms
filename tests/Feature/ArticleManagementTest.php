<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
use App\Models\Manager;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ArticleManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        DB::purge('sqlite');
        DB::reconnect('sqlite');

        Artisan::call('migrate:fresh', [
            '--seed' => false,
        ]);
    }

    public function test_can_create_and_list_articles(): void
    {
        $manager = Manager::create([
            'name' => '管理员',
            'account' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $category = ArticleCategory::create([
            'name' => '技术',
            'slug' => 'tech',
            'description' => '技术文章',
            'is_valid' => true,
            'sort_order' => 1,
        ]);

        $tag = ArticleTag::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
            'description' => 'Laravel tag',
        ]);

        $response = $this->postJson('/backend/content', [
            'title' => 'Laravel 12 实践',
            'slug' => 'laravel-12-practice',
            'summary' => '实践总结',
            'content' => '<p>hello</p>',
            'category_id' => $category->id,
            'tag_ids' => [$tag->id],
            'author_id' => $manager->id,
            'is_published' => true,
            'is_top' => true,
            'sort_order' => 10,
            'published_at' => now()->toDateTimeString(),
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('articles', [
            'title' => 'Laravel 12 实践',
            'slug' => 'laravel-12-practice',
            'is_published' => true,
        ]);

        $article = Article::query()->where('slug', 'laravel-12-practice')->first();
        $this->assertNotNull($article);
        $this->assertTrue($article->tags()->whereKey($tag->id)->exists());

        $listResponse = $this->getJson('/backend/content/list?limit=10&page=1');
        $listResponse->assertOk();
        $this->assertGreaterThan(0, $listResponse->json('data.total'));

        $categoryListResponse = $this->getJson('/backend/content/category/list?limit=10&page=1');
        $categoryListResponse->assertOk();
        $this->assertGreaterThan(0, $categoryListResponse->json('data.total'));

        $tagListResponse = $this->getJson('/backend/content/tag/list?limit=10&page=1');
        $tagListResponse->assertOk();
        $this->assertGreaterThan(0, $tagListResponse->json('data.total'));

        $newCategoryResponse = $this->postJson('/backend/content/category', [
            'name' => '运营',
            'slug' => 'ops',
            'description' => '运营文章',
            'is_valid' => true,
            'sort_order' => 2,
        ]);
        $newCategoryResponse->assertOk();
        $this->assertDatabaseHas('article_categories', ['slug' => 'ops']);

        $newTagResponse = $this->postJson('/backend/content/tag', [
            'name' => 'Vue3',
            'slug' => 'vue3',
            'description' => 'Vue3 tag',
        ]);
        $newTagResponse->assertOk();
        $this->assertDatabaseHas('article_tags', ['slug' => 'vue3']);

        $updateResponse = $this->putJson('/backend/content/' . $article->id, [
            'title' => 'Laravel 12 实践（更新）',
            'slug' => 'laravel-12-practice-updated',
            'summary' => '更新后的摘要',
            'is_published' => false,
        ]);
        $updateResponse->assertOk();
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Laravel 12 实践（更新）',
            'slug' => 'laravel-12-practice-updated',
            'is_published' => false,
        ]);

        $deleteResponse = $this->deleteJson('/backend/content/' . $article->id);
        $deleteResponse->assertOk();
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_manager_get_options_returns_safe_value_pairs(): void
    {
        $manager = Manager::create([
            'name' => '主账号',
            'account' => 'rootadmin',
            'email' => 'rootadmin@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $options = app(\App\Services\Backend\ManagerService::class)->getOptions();

        $this->assertIsArray($options);
        $this->assertNotEmpty($options);
        $this->assertSame($manager->id, $options[0]['value']);
        $this->assertSame('主账号', $options[0]['name']);
    }

    public function test_content_workflow_supports_publish_status_and_dashboard_stats(): void
    {
        $manager = Manager::create([
            'name' => '运营管理员',
            'account' => 'editor',
            'email' => 'editor@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $response = $this->postJson('/backend/content', [
            'title' => 'SimpleCMS 发布流程',
            'slug' => 'simplecms-publish-flow',
            'summary' => '内容运营流程说明',
            'content' => '<p>publish flow</p>',
            'status' => 'review',
            'seo_title' => 'SimpleCMS 发布流程',
            'seo_description' => '用于验证内容发布和运营统计的文章',
            'seo_keywords' => 'SimpleCMS, CMS, Laravel',
            'is_recommended' => true,
            'is_top' => true,
            'published_at' => now()->toDateTimeString(),
        ]);

        $response->assertOk();

        $article = Article::query()->where('slug', 'simplecms-publish-flow')->first();
        $this->assertNotNull($article);
        $this->assertSame('review', $article->status);
        $this->assertSame('SimpleCMS 发布流程', $article->seo_title);
        $this->assertTrue((bool)$article->is_recommended);

        $stats = app(\App\Services\Backend\DashboardService::class)->getContentStatic();
        $this->assertArrayHasKey('published', $stats);
        $this->assertArrayHasKey('draft', $stats);
        $this->assertArrayHasKey('review', $stats);
        $this->assertArrayHasKey('total', $stats);
    }

    public function test_content_workflow_auto_assigns_author_and_normalizes_publish_state(): void
    {
        $manager = Manager::create([
            'name' => '内容运营',
            'account' => 'content-editor',
            'email' => 'content-editor@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $response = $this->postJson('/backend/content', [
            'title' => '内容审核流',
            'slug' => 'content-review-flow',
            'summary' => '验证自动归属和发布状态一致性',
            'content' => '<p>ready</p>',
            'status' => 'published',
            'is_published' => true,
        ]);

        $response->assertOk();

        $article = Article::query()->where('slug', 'content-review-flow')->first();
        $this->assertNotNull($article);
        $this->assertSame($manager->id, $article->author_id);
        $this->assertSame('published', $article->status);
        $this->assertTrue((bool) $article->is_published);
        $this->assertNotNull($article->published_at);

        $updateResponse = $this->putJson('/backend/content/' . $article->id, [
            'status' => 'draft',
            'is_published' => false,
        ]);

        $updateResponse->assertOk();
        $article->refresh();
        $this->assertSame('draft', $article->status);
        $this->assertFalse((bool) $article->is_published);
    }

    public function test_public_news_pages_expose_published_articles_from_cms(): void
    {
        $manager = Manager::create([
            'name' => '新闻编辑',
            'account' => 'news-editor',
            'email' => 'news-editor@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $response = $this->postJson('/backend/content', [
            'title' => '公有新闻示例',
            'slug' => 'public-news-sample',
            'summary' => '查证前台新闻页从 CMS 读取已发布文章',
            'content' => '<p>这是一个真实的已发布新闻示例。</p>',
            'status' => 'published',
            'is_published' => true,
            'published_at' => now()->toDateTimeString(),
        ]);

        $response->assertOk();

        $newsResponse = $this->get('/news');
        $newsResponse->assertOk();
        $this->assertDatabaseHas('articles', ['slug' => 'public-news-sample', 'status' => 'published']);
        $this->assertStringContainsString('public-news-sample', $newsResponse->getContent());

        $detailResponse = $this->get('/news/public-news-sample');
        $detailResponse->assertOk();
        $this->assertStringContainsString('public-news-sample', $detailResponse->getContent());
    }

    public function test_content_list_supports_status_filter_for_review_and_publish_workflow(): void
    {
        $manager = Manager::create([
            'name' => '内容主管',
            'account' => 'content-manager',
            'email' => 'content-manager@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $this->postJson('/backend/content', [
            'title' => '待审核文章',
            'slug' => 'pending-review-article',
            'summary' => '审核中文章',
            'content' => '<p>in review</p>',
            'status' => 'review',
            'is_published' => false,
        ])->assertOk();

        $this->postJson('/backend/content', [
            'title' => '已发布文章',
            'slug' => 'published-article',
            'summary' => '已上线文章',
            'content' => '<p>published</p>',
            'status' => 'published',
            'is_published' => true,
            'published_at' => now()->toDateTimeString(),
        ])->assertOk();

        $reviewResponse = $this->getJson('/backend/content/list?status=review&page=1&limit=20');
        $reviewResponse->assertOk();
        $this->assertSame(1, $reviewResponse->json('data.total'));
        $this->assertSame('pending-review-article', $reviewResponse->json('data.items.0.slug'));

        $publishedResponse = $this->getJson('/backend/content/list?status=published&page=1&limit=20');
        $publishedResponse->assertOk();
        $this->assertSame(1, $publishedResponse->json('data.total'));
        $this->assertSame('published-article', $publishedResponse->json('data.items.0.slug'));
    }

    public function test_public_news_pages_expose_article_metadata_and_tags(): void
    {
        $manager = Manager::create([
            'name' => '内容运营',
            'account' => 'metadata-editor',
            'email' => 'metadata-editor@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $category = ArticleCategory::create([
            'name' => '企业资讯',
            'slug' => 'enterprise-news',
            'description' => '企业资讯类',
            'is_valid' => true,
            'sort_order' => 1,
        ]);

        $tag = ArticleTag::create([
            'name' => '数字化转型',
            'slug' => 'digital-transformation',
            'description' => '数字化转型',
        ]);

        $this->postJson('/backend/content', [
            'title' => '企业数字化转型案例',
            'slug' => 'digital-transformation-case',
            'summary' => '从内容到增长的实践路线',
            'content' => '<p>本文说明企业数字化转型方案。</p>',
            'category_id' => $category->id,
            'tag_ids' => [$tag->id],
            'status' => 'published',
            'is_published' => true,
            'published_at' => now()->toDateTimeString(),
        ])->assertOk();

        $response = $this->get('/news');
        $response->assertOk();
        $this->assertStringContainsString('\\u4f01\\u4e1a\\u8d44\\u8baf', $response->getContent());
        $this->assertStringContainsString('\\u6570\\u5b57\\u5316\\u8f6c\\u578b', $response->getContent());
        $this->assertStringContainsString('\\u5185\\u5bb9\\u8fd0\\u8425', $response->getContent());
    }

    public function test_content_review_queue_page_exposes_review_status_items(): void
    {
        $manager = Manager::create([
            'name' => '审核管理员',
            'account' => 'reviewer',
            'email' => 'reviewer@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $this->postJson('/backend/content', [
            'title' => '待审核文章队列',
            'slug' => 'review-queue-article',
            'summary' => '验证审核列表页面',
            'content' => '<p>待审核</p>',
            'status' => 'review',
            'is_published' => false,
        ])->assertOk();

        $response = $this->get('/backend/content/review');
        $response->assertOk();
        $this->assertStringContainsString('Content\\/Review', $response->getContent());
        $this->assertStringContainsString('backend.content.review.page', $response->getContent());

        $listResponse = $this->getJson('/backend/content/list?status=review&page=1&limit=20');
        $listResponse->assertOk();
        $this->assertSame(1, $listResponse->json('data.total'));
        $this->assertSame('review-queue-article', $listResponse->json('data.items.0.slug'));
    }

    public function test_content_review_reject_flow_records_feedback_and_status(): void
    {
        $manager = Manager::create([
            'name' => '审核编辑',
            'account' => 'review-editor',
            'email' => 'review-editor@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $article = Article::create([
            'title' => '需修订文章',
            'slug' => 'needs-revision-article',
            'summary' => '待审核并复核',
            'content' => '<p>待修订</p>',
            'status' => 'review',
            'is_published' => false,
            'author_id' => $manager->id,
        ]);

        $response = $this->postJson('/backend/content/' . $article->id . '/reject', [
            'reason' => '标题不够精准，需要补充主诉求说明。',
        ]);

        $response->assertOk();
        $article->refresh();
        $this->assertSame('draft', $article->status);
        $this->assertFalse((bool) $article->is_published);
        $this->assertStringContainsString('标题不够精准', $article->review_note);
    }

    public function test_content_workflow_supports_review_and_publish_transitions(): void
    {
        $manager = Manager::create([
            'name' => '审核管理员',
            'account' => 'reviewer-role',
            'email' => 'reviewer-role@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $article = Article::create([
            'title' => '待审核文章',
            'slug' => 'pending-review-article',
            'summary' => '准备进入审核流',
            'content' => '<p>待审核</p>',
            'status' => 'draft',
            'is_published' => false,
            'author_id' => $manager->id,
        ]);

        $reviewResponse = $this->postJson('/backend/content/' . $article->id . '/review');
        $reviewResponse->assertOk();
        $article->refresh();
        $this->assertSame('review', $article->status);
        $this->assertFalse((bool) $article->is_published);

        $publishResponse = $this->postJson('/backend/content/' . $article->id . '/publish');
        $publishResponse->assertOk();
        $article->refresh();
        $this->assertSame('published', $article->status);
        $this->assertTrue((bool) $article->is_published);
        $this->assertNotNull($article->published_at);
    }

    public function test_content_version_history_is_created_on_update_and_supports_restore(): void
    {
        $manager = Manager::create([
            'name' => '版本管理员',
            'account' => 'version-admin',
            'email' => 'version-admin@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $article = Article::create([
            'title' => '初版标题',
            'slug' => 'initial-version-title',
            'summary' => '初版摘要',
            'content' => '<p>初始内容</p>',
            'status' => 'draft',
            'author_id' => $manager->id,
        ]);

        $this->putJson('/backend/content/' . $article->id, [
            'title' => '修订后的标题',
            'slug' => 'revised-title',
            'summary' => '修订后的摘要',
            'content' => '<p>修订后的内容</p>',
            'status' => 'draft',
        ])->assertOk();

        $version = $article->versions()->orderBy('created_at')->first();
        $this->assertNotNull($version);
        $this->assertSame('初版标题', $version->title);
        $this->assertDatabaseHas('article_versions', [
            'article_id' => $article->id,
            'title' => '初版标题',
        ]);

        $restoreResponse = $this->postJson('/backend/content/' . $article->id . '/restore-version', [
            'version_id' => $version->id,
        ]);
        $restoreResponse->assertOk();

        $article->refresh();
        $this->assertSame('初版标题', $article->title);
        $this->assertSame('initial-version-title', $article->slug);
        $this->assertSame('<p>初始内容</p>', $article->content);
    }

    public function test_profile_update_routes_resolve_to_existing_controller_methods(): void
    {
        $manager = Manager::create([
            'name' => '资料管理员',
            'account' => 'profile-admin',
            'email' => 'profile-admin@example.com',
            'password' => 'password123',
            'is_super' => true,
            'is_valid' => true,
        ]);

        $this->actingAs($manager, 'web');

        $emailResponse = $this->from('/backend/profile')->post('/backend/profile/email', [
            'email' => 'profile-admin-new@example.com',
            'password' => 'password123',
        ]);
        $emailResponse->assertRedirect('/backend/profile');
        $manager->refresh();
        $this->assertSame('profile-admin-new@example.com', $manager->email);

        $passwordResponse = $this->from('/backend/profile')->post('/backend/profile/password', [
            'current_password' => 'password123',
            'password' => 'newpassword456',
            'password_confirmation' => 'newpassword456',
        ]);
        $passwordResponse->assertRedirect('/backend/profile');
        $this->assertTrue(Hash::check('newpassword456', $manager->fresh()->password));
    }
}
