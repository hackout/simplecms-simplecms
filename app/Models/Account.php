<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Account Model
 
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $account 账号
 * @property int $type 账号类型
 * @property ?string $user_id 用户ID
 * @property ?string $oauth_id OAuth标识
 * @property bool $is_valid 是否启用
 * @property ?Carbon $last_login 最后登录时间
 * @property ?string $last_ip 最后登录IP
 * @property ?array $extra 附加状态
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 */
class Account extends Model
{
    protected $primaryKey = 'account';

    protected $keyType = 'string';

    /**
     * 可输入字段
     */
    protected $fillable = [
        'account',
        'type',
        'user_id',
        'oauth_id',
        'is_valid',
        'last_login',
        'last_ip',
        'extra'
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'type' => 'integer',
        'is_valid' => 'boolean',
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'extra' => 'array'
    ];

    /**
     * 用户信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
