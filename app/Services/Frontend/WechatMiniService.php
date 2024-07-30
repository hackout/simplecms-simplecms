<?php

namespace App\Services\Frontend;

use Illuminate\Support\Collection;
use SimpleCMS\Framework\Exceptions\SimpleException;
use SimpleCMS\Wechat\Facades\MiniProgram;

class WechatMiniService
{
    public function getOpenId(string $code): Collection
    {
        $session = MiniProgram::codeToSession($code);
        if (!$session->has('openid') && $session->has('errmsg')) {
            throw new SimpleException($session->get('errmsg'));
        }
        $login = (new AuthService())->autoLogin($session->get('openid'));
        return collect($login);
    }
}
