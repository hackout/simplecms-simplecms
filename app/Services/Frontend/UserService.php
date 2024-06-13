<?php

namespace App\Services\Frontend;

use App\Models\User;
use App\Enums\User as UserEnum;
use SimpleCMS\Framework\Services\SimpleService;

class UserService extends SimpleService
{

    public ?string $className = User::class;
    
    /**
     * 获取列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array $data
     * @return array
     */
    public function getList(array $data):array
    {
        $condition = [
            'keyword' => ['search', ['id']],
            'date' => ['datetime_range','created_at']
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
