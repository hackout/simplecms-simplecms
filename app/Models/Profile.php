<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SimpleCMS\Framework\Traits\PrimaryKeyUuidTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Profile Model
 
 * @author Dennis Lui <hackout@vip.qq.com>
 *
 * @property string $user_id 用户ID
 * @property ?string $name 姓名
 * @property ?string $birth_date 生日
 * @property ?string $emergency_contact 应急联系人
 * @property ?string $emergency_phone 应急电话
 * @property ?string $emergency_address 应急地址
 * @property-read ?User $user 用户
 * @property-read ?Carbon $created_at 创建时间
 * @property-read ?Carbon $updated_at 更新时间
 */
class Profile extends Model
{
    protected $primaryKey = 'user_id';

    
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * 可输入字段
     */
    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'emergency_contact',
        'emergency_phone',
        'emergency_address',
    ];

    /**
     * 显示字段类型
     */
    public $casts = [
        'birth_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 追加字段
     */
    public $appends = [];


    /**
     * 隐藏关系
     */
    public $hidden = [];


    /**
     * 用户
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Profile::class);
    }

}
