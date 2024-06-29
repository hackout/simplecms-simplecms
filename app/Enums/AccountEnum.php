<?php

namespace App\Enums;

enum AccountEnum: int
{
    case Account = 1;
    case Email = 2;
    case Mobile = 3;
    case Wechat = 4;
    case AliPay = 5;
    case Github = 6;
    case Apple = 7;
    case Google = 8;

    public static function fromValue(int $value): self
    {
        return match ($value) {
            1 => self::Account,
            2 => self::Email,
            3 => self::Mobile,
            4 => self::Wechat,
            5 => self::AliPay,
            6 => self::Github,
            7 => self::Apple,
            8 => self::Google,
            default => self::Account
        };
    }

    /**
     * 需要密码登录
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return boolean
     */
    public function needPassword(): bool
    {
        return match ($this) {
            self::Account => true,
            self::Email => true,
            self::Mobile => true,
            default => false
        };
    }
}
