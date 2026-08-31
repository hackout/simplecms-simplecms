<?php

namespace App\Services\Backend;

use App\Models\ArticleTag;
use SimpleCMS\Framework\Services\SimpleService;

class ArticleTagService extends SimpleService
{
    public string $className = ArticleTag::class;

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
            'date' => ['datetime_range', 'created_at'],
        ];
        parent::listQuery($data, $condition);
        return parent::list();
    }
}
