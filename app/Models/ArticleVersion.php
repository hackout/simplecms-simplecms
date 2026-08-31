<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;

class ArticleVersion extends Model
{
    use PrimaryKeyUuidTrait;

    protected $table = 'article_versions';

    protected $fillable = [
        'article_id',
        'category_id',
        'title',
        'slug',
        'summary',
        'content',
        'review_note',
        'cover',
        'author_id',
        'status',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'is_published',
        'is_top',
        'is_recommended',
        'sort_order',
        'views',
        'published_at',
        'version_number',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_top' => 'boolean',
        'is_recommended' => 'boolean',
        'sort_order' => 'integer',
        'views' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
