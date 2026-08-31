<?php

namespace App\Services\Backend;

use App\Models\ArticleCategory;
use SimpleCMS\Framework\Services\SimpleService;

class ArticleCategoryService extends SimpleService
{
    public string $className = ArticleCategory::class;

    public function getOptions(): array
    {
        return parent::getAll([
            'id as value',
            'name',
            'slug'
        ])->toArray();
    }

    public function getList(array $data): array
    {
        $condition = [
            'keyword' => ['search', ['id', 'name', 'slug', 'description']],
            'status' => ['eq', 'is_valid'],
            'date' => ['datetime_range', 'created_at'],
        ];
        parent::listQuery($data, $condition);
        return parent::list();
    }
}
