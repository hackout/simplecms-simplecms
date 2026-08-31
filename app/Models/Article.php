<?php

namespace App\Models;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;

/**
 * 文章模型
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class Article extends Model
{
    use PrimaryKeyUuidTrait;

    protected $table = 'articles';

    protected $fillable = [
        'id',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ArticleTag::class, 'article_tag')->withTimestamps();
    }

    public function versions()
    {
        return $this->hasMany(ArticleVersion::class, 'article_id')->orderBy('version_number');
    }
}
