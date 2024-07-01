<?php

namespace App\Http\Controllers\Frontend;

use SimpleCMS\Framework\Attributes\ApiName;
use App\Services\Frontend\WechatMiniService;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Controllers\FrontendController as BaseController;

class WechatMiniController extends BaseController
{

    /**
     * 微信小程序
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string            $code
     * @param  WechatMiniService $service
     * @return JsonResponse
     */
    #[ApiName(name: '微信小程序-交换token')]
    public function token(string $code, WechatMiniService $service): JsonResponse
    {
        $result = $service->getOpenId($code);
        return $this->success($result);
    }
}
