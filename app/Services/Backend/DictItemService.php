<?php

namespace App\Services\Backend;

use SimpleCMS\Framework\Models\DictItem;
use SimpleCMS\Framework\Services\SimpleService;

class DictItemService extends SimpleService
{
    public ?string $className = DictItem::class;

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
            'keyword' => ['search', ['name','content']],
            'dict_id' => 'eq'
        ];
        parent::listQuery($data, $condition);
        $result = parent::list();
        return $result;
    }

}
