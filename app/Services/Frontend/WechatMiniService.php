<?php

namespace App\Services\Frontend;

use Illuminate\Support\Collection;
use App\Packages\Wechat\MiniProgram;
use SimpleCMS\Framework\Exceptions\SimpleException;

class WechatMiniService
{
    public function getOpenId(string $code): Collection
    {
        $session = (new MiniProgram())->codeToSession($code);
        if (!$session->has('openid') && $session->has('errmsg')) {
            throw new SimpleException($session->get('errmsg'));
        }
        $login = (new AuthService())->autoLogin($session->get('openid'));
        return collect($login);
    }
}
