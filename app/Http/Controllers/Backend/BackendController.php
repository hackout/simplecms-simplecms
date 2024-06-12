<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;
use App\Services\Backend\SystemConfigService;
use SimpleCMS\Framework\Attributes\ApiName;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

class BackendController extends BaseBackendController
{

    /**
     * ManagerController 获取列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  SystemConfigService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '控制台')]
    public function index(Request $request, SystemConfigService $service): InertiaResponse
    {
        return Inertia::render('Dashboard/Index', [
            'systemInfo' => $service->getSystemInfo()
        ]);
    }

}
