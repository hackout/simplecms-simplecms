<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Illuminate\Http\Request;
use App\Services\Backend\DashboardService;
use App\Services\Backend\SystemConfigService;
use SimpleCMS\Framework\Attributes\ApiName;

/**
 * 演示中心控制器
 *
 * 负责后台管理模板示例页的统一展示与导航入口。
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
#[ApiName(name: '演示中心控制器')]
class DemoController extends BackendController
{
    /**
     * 演示中心首页
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return InertiaResponse
     */
    #[ApiName(name: '演示中心首页')]
    public function index(Request $request, SystemConfigService $service, DashboardService $dashboardService): InertiaResponse
    {
        return Inertia::render('Demo/Index');
    }

    /**
     * CRUD 页面模板示例
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return InertiaResponse
     */
    #[ApiName(name: 'CRUD 页面模板示例')]
    public function crud(): InertiaResponse
    {
        return Inertia::render('Demo/CrudExample');
    }

    /**
     * 详情页面模板示例
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return InertiaResponse
     */
    #[ApiName(name: '详情页面模板示例')]
    public function detail(): InertiaResponse
    {
        return Inertia::render('Demo/DetailExample');
    }

    /**
     * 表单页面模板示例
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return InertiaResponse
     */
    #[ApiName(name: '表单页面模板示例')]
    public function form(): InertiaResponse
    {
        return Inertia::render('Demo/FormExample');
    }

    /**
     * 看板页面模板示例
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return InertiaResponse
     */
    #[ApiName(name: '看板页面模板示例')]
    public function dashboard(): InertiaResponse
    {
        return Inertia::render('Demo/DashboardExample');
    }
}
