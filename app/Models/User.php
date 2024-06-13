<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * User Model
 
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $id 主键
 * @property string $uid UID
 * @property ?string $nickname 昵称
 * @property ?string $password 登录密码
 * @property bool $is_valid 是否正常
 * @property ?Carbon $last_login 最后登录时间
 * @property ?string $last_ip 最后登录IP
 * @property ?string $register_ip 注册IP
 * @property ?string $register_finger 注册指纹
 * @property int $failed_count 失败次数
 * @property-read ?string $avatar 头像
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 * @property-read ?Profile $profile 用户资料
 * @property-read ?Collection<Media> $media 附件
 * @property-read ?Collection<UserGroup> $groups 会员组
 * @property-read ?Collection<Account> $accounts 账号列表
 */
class User extends Model implements HasMedia
{
    use PrimaryKeyUuidTrait, MediaAttributeTrait, HasApiTokens;

    /**
     * Media Key
     */
    const MEDIA_FILE = 'avatar';

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'uid',
        'nickname',
        'password',
        'is_valid',
        'last_login',
        'last_ip',
        'register_ip',
        'register_finger',
        'failed_count'
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'is_valid' => 'boolean',
        'failed_count' => 'integer',
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = ['avatar'];

    /**
     * 隐藏关系
     */
    public $hidden = ['media', 'password'];

    public function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl(static::MEDIA_FILE);
    }

    /**
     * 账号列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return HasMany|Collection<Account>
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * 会员组
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(UserGroup::class, 'users_groups')->withPivot(['valid_at']);
    }

    /**
     * 用户资料
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
