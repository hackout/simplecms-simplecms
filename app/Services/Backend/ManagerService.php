<?php

namespace App\Services\Backend;

use App\Models\Manager;
use Illuminate\Support\Facades\Hash;
use SimpleCMS\Framework\Services\SimpleService;

class ManagerService extends SimpleService
{

    public string $className = Manager::class;

    /**
     * 获取管理员选项列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return array
     */
    public function getOptions(): array
    {
        return parent::getAll([
            'id',
            'name',
            'account'
        ])->map(fn($n) => ['value' => $n['id'], 'name' => $n['name'] ?: $n['account']])
            ->values()->toArray();
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
            'keyword' => ['search', ['id', 'name', 'account', 'email']],
            'date' => ['datetime_range', 'created_at']
        ];
        parent::listQuery($data, $condition);
        $result = parent::list();
        return $result;
    }

    /**
     * 创建账号
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array   $data
     * @param  array   $mediaFields
     * @return boolean
     */
    public function create(array $data, array $mediaFields = []): bool
    {
        $result = false;
        $data['password'] = Hash::make($data['password']);
        $role_ids = array_key_exists('role_ids', $data) ? $data['role_ids'] : [];
        unset($data['role_ids']);
        tap(parent::create($data, $mediaFields), function (bool $status) use (&$result, $role_ids) {
            $result = $status;
            if ($result) {
                if($role_ids)
                {
                    $roleIdList = [];
                    foreach($role_ids as $role_id)
                    {
                        $roleIdList[$role_id] = ['model_type'=>Manager::class];
                    }
                    $this->item->roles()->sync($roleIdList);
                }
            }
        });
        return $result;
    }

    /**
     * 更新账号资料
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array   $data
     * @param  array   $mediaFields
     * @return boolean
     */
    public function update(string|int $id, array $data, array $mediaFields = []): bool
    {
        $result = false;
        $role_ids = array_key_exists('role_ids', $data) ? $data['role_ids'] : [];
        unset($data['role_ids']);
        tap(parent::update($id, $data, $mediaFields), function (bool $status) use (&$result, $role_ids) {
            $result = $status;
            if ($result) {
                if($role_ids)
                {
                    $roleIdList = [];
                    foreach($role_ids as $role_id)
                    {
                        $roleIdList[$role_id] = ['model_type'=>Manager::class];
                    }
                    $this->item->roles()->sync($roleIdList);
                }
            }
        });
        return $result;
    }

    /**
     * 修改密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string|integer $id
     * @param  string         $password
     * @return void
     */
    public function password(string|int $id, string $password): void
    {
        $password = Hash::make($password);
        parent::setValue($id, 'password', $password);
    }

    /**
     * 更新登录时间
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string|integer $id
     * @return void
     */
    public function login(string|int $id): void
    {
        $sql = [
            'last_ip' => request()->getClientIp(),
            'last_login' => now()
        ];
        parent::update($id, $sql);
    }
}
