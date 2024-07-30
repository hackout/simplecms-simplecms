<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use App\Services\Backend\SystemConfigService;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Requests\SimpleRequest;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

class SystemController extends BaseBackendController
{

    /**
     * 系统设置页面
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  SystemConfigService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '系统设置')]
    public function index(SimpleRequest $request, SystemConfigService $service): InertiaResponse
    {
        return Inertia::render('System/Index', [
            'systemConfig' => $service->getSystemConfig()
        ]);
    }

    /**
     * 获取系统参数列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  SystemConfigService $service
     * @return JsonResponse
     */
    #[ApiName(name: '获取系统参数列表')]
    public function list(SimpleRequest $request, SystemConfigService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250',
            'type' => 'sometimes|nullable|in:' . $service->getTypeList()->join(',')
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'type.enum' => '类型不正确'
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->getList($data);
        return $this->success($result);
    }


    /**
     * 系统缓存管理
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest             $request
     * @param  SystemConfigService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '系统缓存管理')]
    public function cache(SimpleRequest $request, SystemConfigService $service): InertiaResponse
    {
        return Inertia::render('System/Cache', [
            'cache' => $service->getCacheSize()
        ]);
    }

    /**
     * 清理系统缓存
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SystemConfigService $service
     * @return JsonResponse
     */
    #[ApiName(name: '清理系统缓存')]
    public function cacheClear(SystemConfigService $service): JsonResponse
    {
        $service->clearSystemCache();
        return $this->success();
    }

    /**
     * 创建系统参数
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  SystemConfigService $service
     * @return JsonResponse
     */
    #[ApiName(name: '创建系统参数')]
    public function create(SimpleRequest $request, SystemConfigService $service): JsonResponse
    {
        $rules = [
            'name' => 'required|between:2,50',
            'code' => 'required|unique:system_configs,code',
            'description' => 'sometimes|nullable|max:250',
            'options' => 'sometimes|nullable',
            'sort_order' => 'sometimes|nullable|integer',
            'type' => 'required|in:' . $service->getTypeList()->join(',')
        ];
        $messages = [
            'name.required' => '名称不能为空',
            'name.between' => '名称仅支持2-50个字符',
            'code.required' => '标识不能为空',
            'code.unique' => '标识已存在',
            'description.max' => '参数描述不能超过250个字符',
            'sort_order.integer' => '排序不正确',
            'type.required' => '参数类型不能为空',
            'type.in' => '参数类型不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->create($data);
        return $this->success();
    }

    /**
     * 修改系统参数
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string              $slug
     * @param  SimpleRequest             $request
     * @param  SystemConfigService $service
     * @return JsonResponse
     */
    #[ApiName(name: '修改系统参数')]
    public function update(string $slug, SimpleRequest $request, SystemConfigService $service): JsonResponse
    {
        $rules = [
            'name' => 'required|between:2,50',
            'code' => 'required|exists:system_configs,code|in:' . $slug,
            'description' => 'sometimes|nullable|max:250',
            'options' => 'sometimes|nullable',
            'sort_order' => 'sometimes|nullable|integer',
            'type' => 'required|in:' . $service->getTypeList()->join(',')
        ];
        $messages = [
            'name.required' => '名称不能为空',
            'name.between' => '名称仅支持2-50个字符',
            'code.required' => '标识不能为空',
            'code.exists' => '标识已存在',
            'code.in' => '标识不正确',
            'description.max' => '参数描述不能超过250个字符',
            'sort_order.integer' => '排序不正确',
            'type.required' => '参数类型不能为空',
            'type.in' => '参数类型不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->update($slug, $data);
        return $this->success();
    }

    /**
     * 删除系统参数
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest             $request
     * @param  SystemConfigService $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除系统参数')]
    public function delete(string $slug, SimpleRequest $request, SystemConfigService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:system_configs,id',
        ];
        $messages = [
            'id.exists' => '系统参数不存在',
        ];
        $validator = Validator::make(array_merge([
            'code' => $slug
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $service->delete($slug);
        return $this->success();
    }

    /**
     * 修改系统参数
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest             $request
     * @param  SystemConfigService $service
     * @return JsonResponse
     */
    #[ApiName(name: '修改系统参数')]
    public function save(SimpleRequest $request, SystemConfigService $service): JsonResponse
    {
        list($rules, $messages) = $service->getValidation();
        $data = $request->validate($rules, $messages);
        $service->save($data);
        return $this->success();
    }
}