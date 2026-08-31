<?php

namespace App\Http\Controllers\Frontend;

use SimpleCMS\Framework\Attributes\ApiName;
use SimpleCMS\Wechat\Http\Controllers\MiniProgramController as BaseController;

/**
 * 微信小程序控制器
 *
 * 兼容框架升级后的微信小程序 token 入口。
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 * @property-read mixed $service 业务服务
 */
#[ApiName(name: '微信小程序控制器')]
class WechatMiniController extends BaseController {}
