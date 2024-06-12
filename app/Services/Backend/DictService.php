<?php

namespace App\Services\Backend;

use SimpleCMS\Framework\Models\Dict;
use SimpleCMS\Framework\Services\SimpleService;

class DictService extends SimpleService
{

    public ?string $className = Dict::class;

    /**
     * 获取列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array $data
     * @return array
     */
    public function getList(array $data): array
    {
        $condition = [
            'keyword' => ['search', ['name','code']]
        ];
        parent::listQuery($data, $condition);
        $result = parent::list();
        return $result;
    }
}
