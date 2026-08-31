<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;

/**
 * 内容分类模型
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class ArticleCategory extends Model
{
    use PrimaryKeyUuidTrait;

    protected $table = 'article_categories';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'parent_id',
        'description',
        'sort_order',
        'is_valid',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_valid' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
