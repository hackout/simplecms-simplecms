<?php

namespace App\Services\Backend;

use App\Models\UserGroup;
use SimpleCMS\Framework\Services\SimpleService;

class UserGroupService extends SimpleService
{

    public ?string $className = UserGroup::class;

    /**
     * 获取会员组选项
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return array
     */
    public function getOptions(): array
    {
        return parent::getAll([
            'id as value',
            'name',
            'icon'
        ])->toArray();
    }

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
            'keyword' => ['search', ['id']],
            'date' => ['datetime_range', 'created_at']
        ];
        parent::listQuery($data, $condition);
        $result = parent::list();
        return $result;
    }

    /**
     * 获取详情
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @return array
     */
    public function detail(string $id): array
    {
        $result = parent::findById($id);

        return $result->toArray();
    }
}
