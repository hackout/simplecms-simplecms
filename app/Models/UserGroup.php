<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 会员组
 
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property int $id 主键
 * @property string $name 会员组名称
 * @property ?string $description 说明
 * @property ?array $extra 附加参数
 * @property bool $is_default 是否默认
 * @property ?int $sort_order 排序
 * @property-read ?string $icon 图标
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 * @property-read ?Collection<User> $users 会员
 * @property-read ?Collection<Media> $media 附件
 */
class UserGroup extends Model implements HasMedia
{
    use MediaAttributeTrait;

    public array $hasOneMedia = ['file'];

    /**
     * Media Key
     */
    const MEDIA_FILE = 'file';

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'extra',
        'is_default',
        'sort_order',
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'sort_order' => 'integer',
        'extra' => 'array',
        'is_default' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = ['icon'];


    /**
     * 隐藏关系
     */
    public $hidden = ['media'];

    public function getIconAttribute()
    {
        return $this->getFirstMediaUrl(static::MEDIA_FILE);
    }


    /**
     * 会员
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_groups')->withPivot(['valid_at']);
    }
}
