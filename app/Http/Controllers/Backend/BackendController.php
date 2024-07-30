<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use App\Services\Backend\DashboardService;
use SimpleCMS\Framework\Attributes\ApiName;
use App\Services\Backend\SystemConfigService;
use Illuminate\Http\Request;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

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
        ]);
    }

}
