<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SimpleCMS\Framework\Facades\Dict;
use App\Services\Frontend\AuthService;
use App\Services\Frontend\AccountService;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use SimpleCMS\Framework\Http\Controllers\FrontendController as BaseController;

class AuthController extends BaseController
{

    /**
     * 会员注册
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  AuthService $service
     * @return JsonResponse
     */
    #[ApiName(name: '会员注册')]
    public function register(Request $request, AuthService $service): JsonResponse
    {
        $rules = [
            'account' => 'required|unique:accounts,account',
            'type' => [
                'required',
                Rule::enum(Account::class)
            ],
            'password' => 'required_if:type,1|required_if:type,2|required_if:type,3',
            'oauth_id' => 'sometimes|nullable',
            'extra' => 'sometimes|nullable|array'
        ];
        $messages = [
            'account.required' => '注册信息不正确',
            'account.unique' => '注册信息已存在',
            'type.required' => '注册信息不正确',
            'type.enum' => '注册信息不正确',
            'password.required_if' => '登录密码不能为空',
            'extra.array' => '注册信息不正确'
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->register($data);
        return $this->success($result);
    }

    /**
     * 通过IP设备引擎等自动注册
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  AccountService $service
     * @return JsonResponse
     */
    #[ApiName(name: '自动注册会员')]
    public function create(Request $request, AccountService $service): JsonResponse
    {
        $rules = [
            //
        ];
        $messages = [
            //
        ];
        $data = $request->validate($rules, $messages);
        $service->create($data);
        return $this->success();
    }

    /**
     * AccountController 编辑信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  Request         $request
     * @param  AccountService $service
     * @return JsonResponse
     */
    #[ApiName(name: 'AccountController-编辑信息')]
    public function update(string $id, Request $request, AccountService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:accounts,id'
        ];
        $messages = [
            'id.exists' => '信息不存在或删除',
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            //Todo..
        ]);
        $service->update($id, $data);
        return $this->success();
    }

    /**
     * AccountController 信息详情
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  Request         $request
     * @param  AccountService $service
     * @return JsonResponse
     */
    #[ApiName(name: 'AccountController-信息详情')]
    public function detail(string $id, Request $request, AccountService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:accounts,id'
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
        $result = $service->detail($id);
        return $this->success($result);
    }


    /**
     * AccountController 删除信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string         $id
     * @param  Request         $request
     * @param  CommitInlineService $commitInlineService
     * @return JsonResponse
     */
    #[ApiName(name: 'AccountController-删除信息')]
    public function delete(string $id, Request $request, AccountService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:accounts,id'
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
        $data = $validator->safe()->only([
            //Todo..
        ]);
        $service->delete($id, $data);
        return $this->success();
    }


}
