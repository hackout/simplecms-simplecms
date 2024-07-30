<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Services\Backend\RoleService;
use App\Services\Backend\ManagerService;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Requests\SimpleRequest;
use SimpleCMS\Framework\Http\Controllers\BackendController;

class ManagerController extends BackendController
{

    /**
     * 管理员列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  ManagerService $service
     * @return JsonResponse
     */
    #[ApiName(name: '管理员列表')]
    public function index(SimpleRequest $request, ManagerService $service): InertiaResponse
    {
        return Inertia::render('Manager/Index', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null)
            ],
            'roles' => (new RoleService())->getRoleOptions()
        ]);
    }

    /**
     * 获取管理员列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  ManagerService $service
     * @return JsonResponse
     */
    #[ApiName(name: '获取管理员列表')]
    public function list(SimpleRequest $request, ManagerService $service): JsonResponse
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
     * 添加管理员
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  ManagerService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '添加管理员')]
    public function create(SimpleRequest $request, ManagerService $service): JsonResponse
    {
        $rules = [
            'name' => 'sometimes|nullable|between:2,50',
            'account' => 'required|unique:managers,account',
            'email' => 'required|unique:managers,email',
            'password' => 'required|confirmed|between:6,20',
            'is_valid' => 'sometimes|nullable|boolean',
            'role_ids' => 'sometimes|nullable|array',
            'role_ids.*' => 'exists:roles,id'
        ];
        $messages = [
            'name.between' => '姓名仅支持2-50个字符',
            'account.required' => '登录账号不能为空',
            'account.unique' => '登录账号已存在',
            'email.required' => '密保邮箱不能为空',
            'email.unique' => '密保邮箱已存在',
            'password.confirmed' => '两次输入的密码不相符',
            'password.required' => '登录密码不能为空',
            'password.between' => '登录密码仅支持6-20位字符串',
            'is_valid.boolean' => '账号状态不正确',
            'role_ids.array' => '账号角色不正确',
            'role_ids.*.exists' => '账号角色不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->create($data);
        return $this->success();
    }

    /**
     * 编辑管理员
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  ManagerService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '编辑管理员')]
    public function update(string $id, SimpleRequest $request, ManagerService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:managers,id',
            'name' => 'sometimes|nullable|between:2,50',
            'account' => 'required|unique:managers,account,' . $id,
            'email' => 'required|unique:managers,email,' . $id,
            'is_valid' => 'sometimes|nullable|boolean',
            'role_ids' => 'sometimes|nullable|array',
            'role_ids.*' => 'exists:roles,id'
        ];
        $messages = [
            'id.exists' => '账号不存在',
            'name.between' => '姓名仅支持2-50个字符',
            'account.required' => '登录账号不能为空',
            'account.unique' => '登录账号已存在',
            'email.required' => '密保邮箱不能为空',
            'email.unique' => '密保邮箱已存在',
            'is_valid.boolean' => '账号状态不正确',
            'role_ids.array' => '账号角色不正确',
            'role_ids.*.exists' => '账号角色不正确',
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'name',
            'account',
            'email',
            'is_valid',
            'role_ids'
        ]);
        $service->update($id, $data);
        return $this->success();
    }

    /**
     * 修改管理员密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  ManagerService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '修改管理员密码')]
    public function password(string $id, SimpleRequest $request, ManagerService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:managers,id',
            'password' => 'required|confirmed|between:6,20',
        ];
        $messages = [
            'id.exists' => '账号不存在',
            'password.required' => '登录密码不能为空',
            'password.confirmed' => '两次输入的密码不相符',
            'password.between' => '登录密码仅支持6-20位字符串',
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'password'
        ]);
        $service->password($id, $data['password']);
        return $this->success();
    }

    /**
     * 删除管理员
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  ManagerService $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除管理员')]
    public function delete(int $id, SimpleRequest $request, ManagerService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:managers,id',
        ];
        $messages = [
            'id.exists' => '管理员不存在',
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
