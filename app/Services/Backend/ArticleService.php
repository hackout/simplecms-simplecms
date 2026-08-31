<?php

namespace App\Services\Backend;

use App\Models\Article;
use SimpleCMS\Framework\Services\SimpleService;

class ArticleService extends SimpleService
{
    public string $className = Article::class;

    public function getList(array $data): array
    {
        $condition = [
            'keyword' => ['search', ['title', 'slug', 'summary', 'content']],
            'status' => ['eq', 'status'],
            'category_id' => ['eq', 'category_id'],
            'date' => ['datetime_range', 'created_at'],
        ];

        parent::listQuery($data, $condition);
        $result = parent::list();
        $ids = $result['items']->pluck('id')->filter()->all();

        $articles = Article::query()
            ->with(['category', 'author', 'tags'])
            ->when($ids !== [], fn ($query) => $query->whereIn('id', $ids))
            ->get()
            ->keyBy('id');

        $result['items'] = $result['items']->map(function ($item) use ($articles) {
            $article = $articles->get($item['id']);
            if (!$article) {
                return $item;
            }

            return [
                'id' => $article->id,
                'category_id' => $article->category_id,
                'category' => $article->category?->name,
                'title' => $article->title,
                'slug' => $article->slug,
                'summary' => $article->summary,
                'content' => $article->content,
                'cover' => $article->cover,
                'author_id' => $article->author_id,
                'author' => $article->author?->name ?? $article->author?->account,
                'status' => $article->status ?? 'draft',
                'seo_title' => $article->seo_title,
                'seo_description' => $article->seo_description,
                'seo_keywords' => $article->seo_keywords,
                'is_published' => (bool) $article->is_published,
                'is_top' => (bool) $article->is_top,
                'is_recommended' => (bool) $article->is_recommended,
                'sort_order' => $article->sort_order,
                'views' => $article->views,
                'published_at' => $article->published_at,
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
                'tags' => $article->tags->map(fn ($tag) => ['id' => $tag->id, 'name' => $tag->name, 'slug' => $tag->slug])->values(),
            ];
        });

        return $result;
    }

    public function create(array $data, array $mediaFields = []): bool
    {
        $data = $this->normalizeArticleWorkflow($data);
        $tagIds = $this->normalizeTagIds($data);

        $result = false;
        tap(parent::create($data, $mediaFields), function (bool $status) use (&$result, $tagIds) {
            $result = $status;
            $this->syncTags($tagIds);
        });

        return $result;
    }

    public function update(string|int $id, array $data, array $mediaFields = []): bool
    {
        $data = $this->normalizeArticleWorkflow($data);
        $tagIds = $this->normalizeTagIds($data);

        $article = Article::query()->findOrFail($id);
        $this->snapshotVersion($article);

        $result = false;
        tap(parent::update($id, $data, $mediaFields), function (bool $status) use (&$result, $tagIds) {
            $result = $status;
            $this->syncTags($tagIds);
        });

        return $result;
    }

    public function review(string|int $id): bool
    {
        $article = Article::query()->findOrFail($id);

        return (bool) $article->update([
            'status' => 'review',
            'is_published' => false,
            'published_at' => null,
            'review_note' => null,
        ]);
    }

    public function reject(string|int $id, ?string $reason = null): bool
    {
        $article = Article::query()->findOrFail($id);

        return (bool) $article->update([
            'status' => 'draft',
            'is_published' => false,
            'published_at' => null,
            'review_note' => $reason ?: '已退回修改，请根据反馈继续完善内容。',
        ]);
    }

    public function publish(string|int $id): bool
    {
        $article = Article::query()->findOrFail($id);

        return (bool) $article->update([
            'status' => 'published',
            'is_published' => true,
            'published_at' => $article->published_at ?? now(),
            'review_note' => null,
        ]);
    }

    public function restoreVersion(string|int $articleId, string|int $versionId): bool
    {
        $article = Article::query()->findOrFail($articleId);
        $version = $article->versions()->whereKey($versionId)->firstOrFail();

        $payload = [
            'category_id' => $version->category_id,
            'title' => $version->title,
            'slug' => $version->slug,
            'summary' => $version->summary,
            'content' => $version->content,
            'review_note' => $version->review_note,
            'cover' => $version->cover,
            'author_id' => $version->author_id,
            'status' => $version->status,
            'seo_title' => $version->seo_title,
            'seo_description' => $version->seo_description,
            'seo_keywords' => $version->seo_keywords,
            'is_published' => (bool) $version->is_published,
            'is_top' => (bool) $version->is_top,
            'is_recommended' => (bool) $version->is_recommended,
            'sort_order' => $version->sort_order,
            'views' => $version->views,
            'published_at' => $version->published_at,
        ];

        $payload = $this->normalizeArticleWorkflow($payload);

        return (bool) $article->update($payload);
    }

    private function normalizeArticleWorkflow(array $data): array
    {
        $isPublished = array_key_exists('is_published', $data) ? (bool) $data['is_published'] : null;
        $status = $data['status'] ?? null;

        if ($isPublished !== null) {
            $data['is_published'] = $isPublished;
        }

        if (empty($data['author_id'])) {
            $manager = auth()->user();
            if ($manager) {
                $data['author_id'] = $manager->getKey();
            }
        }

        if ($status !== null) {
            $data['status'] = $status;
        } elseif ($isPublished !== null) {
            $data['status'] = $isPublished ? 'published' : 'draft';
        } elseif (empty($data['status'])) {
            $data['status'] = 'draft';
        }

        if (($data['status'] ?? null) === 'published' || ($data['is_published'] ?? false)) {
            $data['is_published'] = true;
            $data['published_at'] = $data['published_at'] ?? now()->toDateTimeString();
        }

        if (($data['status'] ?? null) !== 'published' && !($data['is_published'] ?? false)) {
            $data['published_at'] = null;
        }

        return $data;
    }

    private function normalizeTagIds(array &$data): array
    {
        $tagIds = $data['tag_ids'] ?? [];
        unset($data['tag_ids']);

        return is_array($tagIds) ? array_values(array_unique(array_filter($tagIds, fn ($id) => !empty($id)))) : [];
    }

    private function snapshotVersion(Article $article): void
    {
        $payload = $article->toArray();
        $payload['article_id'] = $article->id;
        $payload['version_number'] = $article->versions()->count() + 1;
        $payload['category_id'] = $article->category_id;

        unset($payload['id'], $payload['created_at'], $payload['updated_at']);

        $article->versions()->create($payload);
    }

    private function syncTags(array $tagIds): void
    {
        if (!$this->item || !method_exists($this->item, 'tags')) {
            return;
        }

        $this->item->tags()->sync($tagIds);
    }
}

