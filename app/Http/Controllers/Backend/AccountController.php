<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Enums\AccountEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SimpleCMS\Framework\Facades\Dict;
use App\Services\Backend\AccountService;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseController;

class AccountController extends BaseController
{

    /**
     * 账号列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  AccountService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '账号管理')]
    public function index(Request $request, AccountService $service): InertiaResponse
    {
        return Inertia::render('User/Account', [
            'query' => [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 20),
                'keyword' => $request->get('keyword', null),
                'type' => $request->get('type', null)
            ],
            'accountType' => Dict::getOptionsByCode('account_type')
        ]);
    }

    /**
     * 会员账号列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  AccountService $service
     * @return JsonResponse
     */
    #[ApiName(name: '会员账号列表')]
    public function list(Request $request, AccountService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250',
            'type' => [
                'sometimes',
                'nullable',
                Rule::enum(AccountEnum::class)
            ]
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'type.enum' => '账号类型不正确',
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->getList($data);
        return $this->success($result);
    }

    /**
     * 变更账号
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string          $id
     * @param  int             $type
     * @param  Request         $request
     * @param  AccountService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '变更账号信息')]
    public function update(string $id, int $type, Request $request, AccountService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:accounts,account,type,' . $type,
            'account' => 'required'
        ];
        $messages = [
            'id.exists' => '账号不存在或已删除'
        ];
        $validator = Validator::make(array_merge([
            'id' => $id,
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only(['account']);
        $service->updateAccount($id, $type, $data['account']);
        return $this->success();
    }

    /**
     * 删除账号信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string          $id
     * @param  Request         $request
     * @param  AccountService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除账号信息')]
    public function delete(string $id, int $type, AccountService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:accounts,account,type,' . $type
        ];
        $messages = [
            'id.exists' => '账号不存在或已删除'
        ];
        $validator = Validator::make([
            'id' => $id,
        ], $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $service->delete($id);
        return $this->success();
    }

}
