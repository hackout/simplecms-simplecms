<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Backend\UserGroupService;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Requests\SimpleRequest;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseController;

class UserGroupController extends BaseController
{

    /**
     * 会员组
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  UserGroupService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '会员组管理')]
    public function index(SimpleRequest $request, UserGroupService $service): InertiaResponse
    {
        return Inertia::render('User/Group', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null)
            ]
        ]);
    }

    /**
     * 会员组列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  UserGroupService $service
     * @return JsonResponse
     */
    #[ApiName(name: '会员组列表')]
    public function list(SimpleRequest $request, UserGroupService $service): JsonResponse
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
     * 添加会员组
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  UserGroupService $service
     * @return JsonResponse
     */
    #[ApiName(name: '添加会员组')]
    public function create(SimpleRequest $request, UserGroupService $service): JsonResponse
    {
        $rules = [
            'name' => 'required|between:2,50',
            'is_default' => 'sometimes|nullable|boolean',
            'description' => 'sometimes|nullable|max:250',
            'sort_order' => 'sometimes|nullable|integer'
        ];
        $messages = [
            'name.required' => '名称不能为空',
            'name.between' => '名称长度仅支持2-50个字符',
            'is_default.boolean' => '默认状态不正确',
            'description.max' => '说明最大支持250个字符',
            'sort_order.integer' => '排序不正确'
        ];
        $data = $request->validate($rules, $messages);
        $service->create($data);
        return $this->success();
    }

    /**
     * 编辑会员组
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  SimpleRequest $request
     * @param  UserGroupService $service
     * @return JsonResponse
     */
    #[ApiName(name: '编辑会员组')]
    public function update(string $id, SimpleRequest $request, UserGroupService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:user_groups,id',
            'name' => 'required|between:2,50',
            'is_default' => 'sometimes|nullable|boolean',
            'description' => 'sometimes|nullable|max:250',
            'sort_order' => 'sometimes|nullable|integer'
        ];
        $messages = [
            'id.exists' => '会员组不存在或删除',
            'name.required' => '名称不能为空',
            'name.between' => '名称长度仅支持2-50个字符',
            'is_default.boolean' => '默认状态不正确',
            'description.max' => '说明最大支持250个字符',
            'sort_order.integer' => '排序不正确'
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'name',
            'is_default',
            'description',
            'sort_order',
        ]);
        $service->update($id, $data);
        return $this->success();
    }

    /**
     * 删除会员组
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string           $id
     * @param  SimpleRequest          $request
     * @param  UserGroupService $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除会员组')]
    public function delete(string $id, SimpleRequest $request, UserGroupService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:user_groups,id'
        ];
        $messages = [
            'id.exists' => '会员组不存在或删除',
        ];
        $validator = Validator::make([
            'id' => $id
        ], $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $service->delete($id);
        return $this->success();
    }

}
