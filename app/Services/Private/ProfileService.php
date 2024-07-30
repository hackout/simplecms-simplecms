<?php

namespace App\Services\Private;

use App\Models\User;
use App\Models\Profile;
use SimpleCMS\Framework\Services\SimpleService;

class ProfileService extends SimpleService
{
    public string $className = Profile::class;

    /**
     * 创建用户资料
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  User $user
     * @return void
     */
    public function createByUser(User $user): void
    {
        $sql = [
            'user_id' => $user->id,
            'name' => null,
            'birth_date' => null,
            'emergency_contact' => null,
            'emergency_phone' => null,
            'emergency_address' => null,
        ];
        $this->create($sql);
    }
}