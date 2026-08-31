<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use App\Services\Backend\DashboardService;
use SimpleCMS\Framework\Attributes\ApiName;
use App\Services\Backend\SystemConfigService;
use Illuminate\Http\Request;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

/**
 * 后台控制器
 *
 * 负责后台首页仪表盘与系统信息的统一展示与入口控制。
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 * @property-read Request $request 请求对象
 * @property-read SystemConfigService $service 系统配置服务
 * @property-read DashboardService $dashboardService 仪表盘服务
 */
#[ApiName(name: '后台控制器')]
class BackendController extends BaseBackendController
{

    /**
     * 控制台
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  SystemConfigService $service
     * @param  DashboardService    $dashboardService
     * @return InertiaResponse
     */
    #[ApiName(name: '控制台')]
    public function index(Request $request, SystemConfigService $service, DashboardService $dashboardService): InertiaResponse
    {
        return Inertia::render('Dashboard/Index', [
            'systemInfo' => $service->getSystemInfo(),
            'user_static' => $dashboardService->getUserStatic(),
            'manager_static' => $dashboardService->getManagerStatic(),
            'log_static' => $dashboardService->getLogStatic(),
            'content_static' => $dashboardService->getContentStatic(),
        ]);
    }

}
