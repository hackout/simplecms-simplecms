<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\Frontend\PublicService;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Controllers\FrontendController as BaseController;

class PublicController extends BaseController
{

    /**
     * 小程序初始化
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
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
