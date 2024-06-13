<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Services\Backend\UserLogService;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseController;

class UserLogController extends BaseController
{

    /**
     * 获取会员日志
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string          $id
     * @param  Request         $request
     * @param  UserLogService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '获取会员日志')]
    public function list(string $id, Request $request, UserLogService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:users,id',
            'keyword' => 'sometimes|nullable|max:250',
            'date' => 'sometimes|nullable|date',
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'id.exists' => '信息不存在或删除',
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'keyword',
            'id',
            'date'
        ]);
        $result = $service->getList($data);
        return $this->success($result);
    }

    /**
     * 删除会员信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string          $id
     * @param  Request         $request
     * @param  UserLogService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除会员信息')]
    public function delete(string $id, string $log_id, Request $request, UserLogService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:users,id',
            'log_id' => 'exists:request_logs,id,user_id,' . $id
        ];
        $messages = [
            'id.exists' => '信息不存在或删除',
            'log_id.exists' => '信息不存在或删除',
        ];
        $validator = Validator::make([
            'id' => $id,
            'log_id' => $log_id,
        ], $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $service->delete($log_id);
        return $this->success();
    }

    /**
     * 清空会员日志
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string          $id
     * @param  UserLogService  $service
     * @return JsonResponse
     */
    #[ApiName(name: '清空会员日志')]
    public function clean(string $id, UserLogService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:users,id'
        ];
        $messages = [
            'id.exists' => '信息不存在或删除',
        ];
        $validator = Validator::make([
            'id' => $id,
        ], $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $service->cleanLog($id);
        return $this->success();
    }
}
