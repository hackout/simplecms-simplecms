<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * User Model
 
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $id 主键
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 * @property-read ?Collection<Media> $media 附件
 * @property-read ?array<array<string,string>> $thumbnails 附件记录
 */
class User extends Model implements HasMedia
{
    use PrimaryKeyUuidTrait,MediaAttributeTrait;

    /**
     * Media Key
     */
    const MEDIA_FILE = 'file';

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        //..Todo
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = ['thumbnails'];


    /**
     * 隐藏关系
     */
    public $hidden = ['media'];
    
    public function getThumbnailsAttribute()
    {
        if (!$medias = $this->getMedia(self::MEDIA_FILE))
            return [];
        return $medias->map(function ($item) {
            return [
                'name' => $item->file_name,
                'url' => $item->original_url,
                'uuid' => $item->uuid
            ];
        });
    }
}
