<?php

namespace App\Http\Controllers\Frontend;

use App\Services\Frontend\ProfileService;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use SimpleCMS\Framework\Http\Controllers\FrontendController as BaseController;

class ProfileController extends BaseController
{

    /**
     * ProfileController 获取列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  ProfileService $service
     * @return JsonResponse
     */
    #[ApiName(name: 'ProfileController-获取列表')]
    public function index(Request $request, ProfileService $service): JsonResponse
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
     * ProfileController 添加信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @param  ProfileService $service
     * @return JsonResponse
     */
    #[ApiName(name: 'ProfileController-添加信息')]
    public function create(Request $request, ProfileService $service): JsonResponse
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
     * ProfileController 编辑信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  Request $request
     * @param  ProfileService $service
     * @return JsonResponse
     */
    #[ApiName(name: 'ProfileController-编辑信息')]
    public function update(string $id, Request $request, ProfileService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:profiles,id'
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
     * ProfileController 信息详情
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  Request $request
     * @param  ProfileService $service
     * @return JsonResponse
     */
    #[ApiName(name: 'ProfileController-信息详情')]
    public function detail(string $id, Request $request, ProfileService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:profiles,id'
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
     * ProfileController 删除信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string         $id
     * @param  Request $request
     * @param  ProfileService $service
     * @return JsonResponse
     */
    #[ApiName(name: 'ProfileController-删除信息')]
    public function delete(string $id, Request $request, ProfileService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:profiles,id'
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
