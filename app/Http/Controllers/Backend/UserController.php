<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Services\Backend\UserService;
use App\Services\Backend\ProfileService;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Backend\UserGroupService;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseController;

class UserController extends BaseController
{

    /**
     * 会员列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  UserService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '会员列表')]
    public function index(Request $request, UserService $service): InertiaResponse
    {
        return Inertia::render('User/Index', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null),
                'group_id' => $request->get('group_id', null),
                'created_at' => $request->get('created_at', null)
            ],
            'defaultPassword' => $service->getDefaultPassword(),
            'userGroup' => (new UserGroupService())->getOptions()
        ]);
    }

    /**
     * 获取会员列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  UserService $service
     * @return JsonResponse
     */
    #[ApiName(name: '获取会员列表')]
    public function list(Request $request, UserService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250',
            'group_id' => 'sometimes|nullable|exists:user_groups,id',
            'created_at' => 'sometimes|nullable|date',
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'group_id.exists' => '会员组不存在',
            'created_at.date' => '注册时间不正确'
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->getList($data);
        return $this->success($result);
    }

    /**
     * 修改密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  Request $request
     * @param  UserService $service
     * @return JsonResponse
     */
    #[ApiName(name: '修改用户密码')]
    public function password(string $id, Request $request, UserService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:users,id',
            'password' => 'required|confirmed'
        ];
        $messages = [
            'id.exists' => '信息不存在或删除',
            'password.required' => '登录密码不能为空',
            'password.confirmed' => '两次输入的登录密码不相符'
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
     * 修改资料
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  Request $request
     * @param  UserService $service
     * @return JsonResponse
     */
    #[ApiName(name: '修改用户基础资料')]
    public function update(string $id, Request $request, UserService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:users,id',
            'nickname' => 'required|between:2,50',
            'avatar' => 'sometimes|nullable|image'
        ];
        $messages = [
            'id.exists' => '信息不存在或删除',
            'nickname.required' => '昵称不能为空',
            'nickname.between' => '昵称仅支持2-50个字符',
            'avatar.image' => '头像不能为空'
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'nickname',
            'avatar'
        ]);
        $service->update($id, $data);
        return $this->success();
    }


    /**
     * 修改个人资料
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  Request $request
     * @param  ProfileService $service
     * @return JsonResponse
     */
    #[ApiName(name: '修改个人资料')]
    public function profile(string $id, Request $request, ProfileService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:users,id',
            'name' => 'sometimes|nullable|between:2,50',
            'birth_date' => 'sometimes|nullable|date',
            'emergency_contact' => 'sometimes|nullable|between:2,50',
            'emergency_phone' => 'sometimes|nullable|between:2,50',
            'emergency_address' => 'sometimes|nullable|between:2,50',
        ];
        $messages = [
            'id.exists' => '信息不存在或删除',
            'name.between' => '姓名仅支持2-50个字符',
            'birth_date.date' => '生日格式不正确',
            'emergency_contact.between' => '联系人仅支持2-50个字符',
            'emergency_phone.between' => '联系电话仅支持2-50个字符',
            'emergency_address.between' => '联系地址仅支持2-50个字符',
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'name',
            'birth_date',
            'emergency_contact',
            'emergency_phone',
            'emergency_address',
        ]);
        $service->update($id, $data);
        return $this->success();
    }

    /**
     * 会员详情
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  Request $request
     * @param  UserService $service
     * @return InertiaResponse|
     */
    #[ApiName(name: '查看会员详情')]
    public function detail(string $id, Request $request, UserService $service): InertiaResponse
    {
        $rules = [
            'id' => 'exists:users,id'
        ];
        $messages = [
            'id.exists' => '信息不存在或删除',
        ];
        $validator = Validator::make([
            'id' => $id
        ], $rules, $messages);
        if ($validator->fails()) {
            abort(404);
        }
        return Inertia::render('User/Detail', [
            'item' => $service->detail($id)
        ]);
    }


    /**
     * 删除会员信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string          $id
     * @param  Request $request
     * @param  UserService     $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除会员信息')]
    public function delete(string $id, Request $request, UserService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:users,id'
        ];
        $messages = [
            'id.exists' => '信息不存在或删除',
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
