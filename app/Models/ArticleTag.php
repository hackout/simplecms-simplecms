<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;

/**
 * 内容标签模型
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class ArticleTag extends Model
{
    use PrimaryKeyUuidTrait;

    protected $table = 'article_tags';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tag');
    }
}
