<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Services\Backend\ManagerService;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Backend\RequestLogService;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

class ManagerLogController extends BaseBackendController
{

    /**
     * 导航菜单设置
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  RequestLogService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '导航菜单设置')]
    public function index(Request $request, RequestLogService $service): InertiaResponse
    {
        return Inertia::render('Manager/Log', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null),
                'manager_id' => $request->get('manager_id', null)
            ],
            'managerList' => (new ManagerService)->getOptions()
        ]);
    }

    /**
     * 导航菜单列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  RequestLogService $service
     * @return JsonResponse
     */
    #[ApiName(name: '导航菜单列表')]
    public function list(Request $request, RequestLogService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250',
            'manager_id' => 'sometimes|nullable|exists:managers,id'
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'manager_id.exists' => '管理员不存在'
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->getList($data);
        return $this->success($result);
    }

    /**
     * 删除操作记录
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string            $id
     * @param  Request $request
     * @param  RequestLogService $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除操作记录')]
    public function delete(string $id, Request $request, RequestLogService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:request_logs,id',
        ];
        $messages = [
            'id.exists' => '日志不存在',
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $service->delete($id);
        return $this->success();
    }

    /**
     * 清空操作日志
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  RequestLogService $service
     * @return JsonResponse
     */
    #[ApiName(name: '清空操作日志')]
    public function clean(RequestLogService $service): JsonResponse
    {
        $service->clean();
        return $this->success();
    }
}
