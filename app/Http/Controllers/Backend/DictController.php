<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Services\Backend\DictService;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

class DictController extends BaseBackendController
{
    /**
     * 数据字典
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @return InertiaResponse
     */
    #[ApiName(name: '数据字典')]
    public function index(Request $request): InertiaResponse
    {
        return Inertia::render('System/Dict', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null)
            ]
        ]);
    }

    /**
     * 数据字典列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  DictService $service
     * @return JsonResponse
     */
    #[ApiName(name: '数据字典列表')]
    public function list(Request $request, DictService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250'
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符'
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->getList($data);
        return $this->success($result);
    }

    /**
     * 添加数据字典
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  DictService $service
     * @return JsonResponse
     */
    #[ApiName(name: '添加数据字典')]
    public function create(Request $request, DictService $service): JsonResponse
    {
        $rules = [
            'name' => 'required|between:2,50',
            'code' => 'required|unique:dicts,code|between:3,50',
            'sort_order' => 'sometimes|nullable|integer',
        ];
        $messages = [
            'name.required' => '名称不能为空',
            'name.between' => '名称仅支持2-50个字符',
            'code.required' => '标识不能为空',
            'code.unique' => '标识已存在',
            'code.between' => '标识仅支持3-50个字符',
            'sort_order.integer' => '排序仅支持数字',
        ];
        $data = $request->validate($rules, $messages);
        $service->create($data);
        return $this->success();
    }

    /**
     * 编辑数据字典
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @param  Request $request
     * @param  DictService $service
     * @return JsonResponse
     */
    #[ApiName(name: '编辑数据字典')]
    public function update(int $id, Request $request, DictService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:dicts,id',
            'name' => 'required|between:2,50',
            'code' => 'required|unique:dicts,code,' . $id . ',id|between:3,50',
            'sort_order' => 'sometimes|nullable|integer',
        ];
        $messages = [
            'id.exists' => '字典不存在',
            'name.required' => '名称不能为空',
            'name.between' => '名称仅支持2-50个字符',
            'code.required' => '标识不能为空',
            'code.unique' => '标识已存在',
            'code.between' => '标识仅支持3-50个字符',
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
            'code',
            'sort_order',
        ]);
        $service->update($id, $data);
        return $this->success();
    }

    /**
     * 删除数据字典
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @param  Request $request
     * @param  DictService $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除数据字典')]
    public function delete(int $id, Request $request, DictService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:dicts,id',
        ];
        $messages = [
            'id.exists' => '字典不存在',
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
