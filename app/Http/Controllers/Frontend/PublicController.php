<?php

namespace App\Http\Controllers\Frontend;

use App\Services\Frontend\PublicService;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Controllers\FrontendController as BaseController;

/**
 * 公共控制器
 *
 * 处理前台公共接口与初始化入口等逻辑。
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 * @property-read mixed $service 业务服务
 */
#[ApiName(name: '公共控制器')]
class PublicController extends BaseController
{

    /**
     * 小程序初始化
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  PublicService $service
     * @return JsonResponse
     */
    #[ApiName(name: '小程序初始化')]
    public function init(PublicService $service): JsonResponse
    {
        $result = $service->init();
        return $this->success($result);
    }
}
