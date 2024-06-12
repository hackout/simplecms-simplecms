<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\Backend\MenuService;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use SimpleCMS\Framework\Facades\Dict;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

class MenuController extends BaseBackendController
{

    /**
     * 导航菜单设置
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  MenuService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '导航菜单设置')]
    public function index(Request $request, MenuService $service): InertiaResponse
    {
        return Inertia::render('System/Menu', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null),
                'type' => $request->get('type', null)
            ],
            'menuType' => Dict::getOptionsByCode('menu_type'),
            'routeList' => $service->getRouteList()
        ]);
    }

    /**
     * 导航菜单列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  MenuService $service
     * @return JsonResponse
     */
    #[ApiName(name: '导航菜单列表')]
    public function list(Request $request, MenuService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250',
            'type' => 'sometimes|nullable|integer'
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'type.integer' => '菜单类型不正确'
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->getList($data);
        return $this->success($result);
    }

    /**
     * 添加导航菜单
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  MenuService $service
     * @return JsonResponse
     */
    #[ApiName(name: '添加导航菜单')]
    public function create(Request $request, MenuService $service): JsonResponse
    {
        $rules = [
            'name' => 'required|between:2,50',
            'icon' => 'sometimes|nullable',
            'uri' => 'required',
            'type' => 'required|in:1,2',
            'parent_id' => 'sometimes|nullable|integer',
            'is_valid' => 'sometimes|nullable|boolean',
            'is_show' => 'sometimes|nullable|boolean',
            'sort_order' => 'sometimes|nullable|integer',
        ];
        $messages = [
            'name.required' => '名称不能为空',
            'name.between' => '名称仅支持2-50个字符',
            'uri.required' => '链接地址不能为空',
            'type.required' => '应用场景不能为空',
            'type.in' => '应用场景不正确',
            'parent_id.integer' => '上级ID不正确',
            'is_valid.boolean' => '有效状态不正确',
            'is_show.boolean' => '显示状态不正确',
            'sort_order.integer' => '排序仅支持数字',
        ];
        $data = $request->validate($rules, $messages);
        $service->createByUri($data);
        return $this->success();
    }

    /**
     * 编辑导航菜单
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  MenuService $service
     * @return JsonResponse
     */
    #[ApiName(name: '编辑导航菜单')]
    public function update(int $id, Request $request, MenuService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:menus,id',
            'name' => 'required|between:2,50',
            'icon' => 'sometimes|nullable',
            'uri' => 'required',
            'type' => 'required|in:1,2',
            'parent_id' => 'sometimes|nullable|integer',
            'is_valid' => 'sometimes|nullable|boolean',
            'is_show' => 'sometimes|nullable|boolean',
            'sort_order' => 'sometimes|nullable|integer',
        ];
        $messages = [
            'id.exists' => '菜单不存在',
            'name.required' => '名称不能为空',
            'name.between' => '名称仅支持2-50个字符',
            'uri.required' => '链接地址不能为空',
            'type.required' => '应用场景不能为空',
            'type.in' => '应用场景不正确',
            'parent_id.integer' => '上级ID不正确',
            'is_valid.boolean' => '有效状态不正确',
            'is_show.boolean' => '显示状态不正确',
            'sort_order.integer' => '排序仅支持数字',
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'name',
            'icon',
            'uri',
            'type',
            'parent_id',
            'is_valid',
            'is_show',
            'sort_order',
        ]);
        $service->updateByUri($id, $data);
        return $this->success();
    }

    /**
     * 删除导航菜单
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  MenuService $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除导航菜单')]
    public function delete(int $id, Request $request, MenuService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:menus,id',
        ];
        $messages = [
            'id.exists' => '菜单不存在',
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
     * 快速编辑菜单
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  MenuService $service
     * @return JsonResponse
     */
    #[ApiName(name: '快速编辑菜单')]
    public function quick(Request $request,MenuService $service):JsonResponse
    {
        $rules = [
            'items' => 'required|min:1|array',
            'items.*.id' => 'required|exists:menus,id',
            'items.*.is_valid' => 'required|boolean',
            'items.*.is_show' => 'required|boolean',
            'items.*.sort_order' => 'required|integer',
        ];
        $messages = [
            'items.required' => '菜单数据不能为空',
            'items.min' => '至少选择一列',
            'items.array' => '菜单信息错误',
            'items.*.id.required' => '菜单ID不能为空',
            'items.*.is_valid.required' => '菜单状态不能为空',
            'items.*.is_show.required' => '显示状态不能为空',
            'items.*.sort_order.required' => '排序不能为空',
            'items.*.id.exists' => '菜单ID不正确',
            'items.*.is_valid.boolean' => '菜单状态不正确',
            'items.*.is_show.boolean' => '显示状态不正确',
            'items.*.sort_order.integer' => '排序不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->quickSave($data);
        return $this->success();
    }
    /**
     * 批量删除菜单
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  MenuService $service
     * @return JsonResponse
     */
    #[ApiName(name: '批量删除菜单')]
    public function batchDelete(Request $request,MenuService $service):JsonResponse
    {
        $rules = [
            'items' => 'required|min:1|array',
            'items.*' => 'required|exists:menus,id',
        ];
        $messages = [
            'items.required' => '菜单数据不能为空',
            'items.min' => '至少选择一列',
            'items.array' => '菜单信息错误',
            'items.*.required' => '菜单ID不能为空',
            'items.*.exists' => '菜单ID不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->batch_delete($data['items']);
        return $this->success();
    }
}
