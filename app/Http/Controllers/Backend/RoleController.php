<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Services\Backend\RoleService;
use SimpleCMS\Framework\Facades\Dict;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use SimpleCMS\Framework\Http\Controllers\BackendController;

class RoleController extends BackendController
{

    /**
     * 角色管理
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  RoleService $service
     * @return JsonResponse
     */
    #[ApiName(name: '角色管理')]
    public function index(Request $request, RoleService $service): InertiaResponse
    {
        return Inertia::render('Manager/Role', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null),
                'type' => $request->get('type', null),
            ],
            'roleType' => Dict::getOptionsByCode('role_type'),
            'routeList' => $service->getRouteList()
        ]);
    }

    /**
     * 获取角色列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  RoleService $service
     * @return JsonResponse
     */
    #[ApiName(name: '获取角色列表')]
    public function list(Request $request, RoleService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250',
            'type' => 'sometimes|nullable|integer'
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'type.integer' => '角色类型不正确'
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->getList($data);
        return $this->success($result);
    }

    /**
     * 添加角色
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  RoleService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '添加角色')]
    public function create(Request $request, RoleService $service): JsonResponse
    {
        $rules = [
            'name' => 'required|between:2,50',
            'description' => 'sometimes|nullable|max:250',
            'type' => 'required|integer',
            'routes' => 'required',
            'sort_order' => 'sometimes|nullable|integer',
        ];
        $messages = [
            'name.required' => '角色名称不能空',
            'name.between' => '角色名称仅支持2-50个字符',
            'description.max' => '角色说明最大支持250个字符',
            'type.required' => '角色类型不能为空',
            'type.integer' => '角色类型不正确',
            'sort_order.integer' => '排序不正确',
            'routes.required' => '角色权限不能为空'
        ];
        $data = $request->validate($rules, $messages);
        $service->create($data);
        return $this->success();
    }

    /**
     * 编辑角色
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  RoleService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '编辑角色')]
    public function update(string $id, Request $request, RoleService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:roles,id',
            'name' => 'required|between:2,50',
            'description' => 'sometimes|nullable|max:250',
            'type' => 'required|integer',
            'routes' => 'required',
            'sort_order' => 'sometimes|nullable|integer',
        ];
        $messages = [
            'id.exists' => '角色不存在',
            'name.required' => '角色名称不能空',
            'name.between' => '角色名称仅支持2-50个字符',
            'description.max' => '角色说明最大支持250个字符',
            'type.required' => '角色类型不能为空',
            'type.integer' => '角色类型不正确',
            'sort_order.integer' => '排序不正确',
            'routes.required' => '角色权限不能为空'
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'name',
            'description',
            'type',
            'routes',
            'sort_order',
        ]);
        $service->update($id, $data);
        return $this->success();
    }

    /**
     * 删除角色
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  RoleService $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除角色')]
    public function delete(int $id, Request $request, RoleService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:roles,id',
        ];
        $messages = [
            'id.exists' => '角色不存在',
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
}
