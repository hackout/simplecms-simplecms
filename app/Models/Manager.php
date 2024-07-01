<?php

namespace App\Models;

use Carbon\Carbon;
use SimpleCMS\Framework\Models\Role;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\Framework\Traits\RequestLogTrait;
use SimpleCMS\Framework\Contracts\RolePermission;
use SimpleCMS\Framework\Traits\MediaAttributeTrait;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;
use SimpleCMS\Framework\Traits\RolePermissionTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 管理员 Model
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 * @property string $id 主键
 * @property string $name 管理员姓名
 * @property string $account 登录账号
 * @property ?string $email 密保邮箱
 * @property ?Carbon $email_verified_at 邮箱验证时间
 * @property string $password 登录密码
 * @property bool $is_super 是否超管
 * @property bool $is_valid 是否可用
 * @property string $created_at 注册时间
 * @property ?Carbon $updated_at 更新时间
 * @property ?Carbon $last_login 最后登录
 * @property ?string $last_ip 注册时间
 * @property int $failed_count 失败次数
 * @property-read ?Collection<Media> $media 附件
 * @property-read ?Collection<Role> $roles 角色
 * @property-read ?string $avatar 用户头像
 */
class Manager extends Authenticatable implements HasMedia, RolePermission
{
    use PrimaryKeyUuidTrait, MediaAttributeTrait, Notifiable, RolePermissionTrait, RequestLogTrait;

    /**
     * Media Key
     */
    const MEDIA_FILE = 'file';

    /**
     * Media Avatar
     */
    const MEDIA_AVATAR = 'avatar';

    /**
     * 可输入字段
     */
    protected $fillable = [
        'id',
        'name',
        'account',
        'email',
        'email_verified_at',
        'password',
        'is_super',
        'is_valid',
        'last_login',
        'last_ip',
        'failed_count',
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'failed_count' => 'integer',
        'is_valid' => 'boolean',
        'is_super' => 'boolean',
        'last_login' => 'datetime',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'password' => 'hashed'
    ];

    /**
     * 追加字段
     */
    public $appends = ['avatar', 'role_ids'];


    /**
     * 隐藏关系
     */
    public $hidden = [
        'password',
        'remember_token',
        'media'
    ];


    public function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl(self::MEDIA_AVATAR);
    }

    public function failRedirect(\Illuminate\Http\Request $request)
    {
        if ($request->ajax()) {
            return json_permission();
        }
        return abort(403);
    }

    public function getRoleIdsAttribute(): array
    {
        return $this->roles->pluck('id')->toArray();
    }
}
