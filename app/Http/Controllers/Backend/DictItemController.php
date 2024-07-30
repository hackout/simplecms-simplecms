<?php

namespace App\Http\Controllers\Backend;

use App\Services\Backend\DictItemService;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use Symfony\Component\HttpFoundation\JsonResponse;
use SimpleCMS\Framework\Http\Requests\SimpleRequest;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

class DictItemController extends BaseBackendController
{

    /**
     * 字典项列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  DictItemService $service
     * @return JsonResponse
     */
    #[ApiName(name: '字典项列表')]
    public function list(SimpleRequest $request, DictItemService $service): JsonResponse
    {
        $rules = [
            'keyword' => 'sometimes|nullable|max:250',
            'dict_id' => 'required|exists:dicts,id'
        ];
        $messages = [
            'keyword.max' => '关键词最大支持250个字符',
            'dict_id.required' => '字典ID不存在',
            'dict_id.exists' => '字典ID不存在',
        ];
        $data = $request->validate($rules, $messages);
        $result = $service->getList($data);
        return $this->success($result);
    }

    /**
     * 添加字典项
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest $request
     * @param  DictItemService $service
     * @return JsonResponse
     */
    #[ApiName(name: '添加字典项')]
    public function create(SimpleRequest $request, DictItemService $service): JsonResponse
    {
        $rules = [
            'name' => 'required',
            'dict_id' => 'required|exists:dicts,id',
            'content' => 'required|integer',
            'sort_order' => 'sometimes|nullable|integer',
            'file' => 'sometimes|nullable|image'
        ];
        $messages = [
            'name.required' => '键名不能为空',
            'name.between' => '键名仅支持2-50个字符',
            'content.required' => '键值不能为空',
            'content.integer' => '键值已存在',
            'dict_id.required' => '字典ID不存在',
            'dict_id.exists' => '字典ID不存在',
            'sort_order.integer' => '排序仅支持数字',
            'file.image' => '缩率图不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->create($data);
        return $this->success();
    }

    /**
     * 编辑字典项
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @param  SimpleRequest $request
     * @param  DictItemService $service
     * @return JsonResponse
     */
    #[ApiName(name: '编辑字典项')]
    public function update(int $id, SimpleRequest $request, DictItemService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:dict_items,id',
            'name' => 'required',
            'dict_id' => 'required|exists:dicts,id',
            'content' => 'required|integer',
            'sort_order' => 'sometimes|nullable|integer',
            'file' => 'sometimes|nullable|image'
        ];
        $messages = [
            'id.exists' => '字典项不存在',
            'name.required' => '键名不能为空',
            'name.between' => '键名仅支持2-50个字符',
            'content.required' => '键值不能为空',
            'content.integer' => '键值已存在',
            'dict_id.required' => '字典ID不存在',
            'dict_id.exists' => '字典ID不存在',
            'sort_order.integer' => '排序仅支持数字',
            'file.image' => '缩率图不正确',
        ];
        $validator = Validator::make(array_merge([
            'id' => $id
        ], $request->all()), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $data = $validator->safe()->only([
            'name',
            'dict_id',
            'content',
            'sort_order',
            'file'
        ]);
        $service->update($id, $data);
        return $this->success();
    }

    /**
     * 删除字典项
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  int $id
     * @param  SimpleRequest $request
     * @param  DictItemService $service
     * @return JsonResponse
     */
    #[ApiName(name: '删除字典项')]
    public function delete(int $id, SimpleRequest $request, DictItemService $service): JsonResponse
    {
        $rules = [
            'id' => 'exists:dict_items,id',
        ];
        $messages = [
            'id.exists' => '字典项不存在',
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
