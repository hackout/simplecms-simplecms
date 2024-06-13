<?php

namespace App\Enums;

enum User: int
{
    case Account = 1;
    case Email = 2;
    case Mobile = 3;
    case Wechat = 4;
    case AliPay = 5;
    case Github = 6;
    case Apple = 7;
    case Google = 8;
}
