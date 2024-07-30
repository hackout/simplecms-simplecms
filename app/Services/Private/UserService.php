<?php

namespace App\Services\Private;

use App\Models\User;
use App\Models\Account;
use SimpleCMS\Framework\Services\SimpleService;

class UserService extends SimpleService
{
    public string $className = User::class;
    
    /**
     * 更新账号登录信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Account $account
     * @return void
     */
    public function updateLogin(Account $account):void
    {
        $sql = [
            'last_login' => $account->last_login,
            'last_ip' => $account->last_ip
        ];
        parent::update($account->user_id,$sql);
    }
}