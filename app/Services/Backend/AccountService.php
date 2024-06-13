<?php

namespace App\Services\Backend;

use App\Models\Account;
use SimpleCMS\Framework\Exceptions\SimpleException;
use SimpleCMS\Framework\Services\SimpleService;
use SimpleCMS\Framework\Traits\ExportTemplateTrait;
use SimpleCMS\Framework\Traits\ImportTemplateTrait;

class AccountService extends SimpleService
{
    use ExportTemplateTrait, ImportTemplateTrait;

    public ?string $className = Account::class;

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
            'keyword' => ['search', ['account', 'extra']],
            'date' => ['datetime_range', 'created_at'],
            'type' => 'eq'
        ];
        parent::listQuery($data, $condition);
        $result = parent::list();
        return $result;
    }

    /**
     * 修改账号信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string  $id
     * @param  integer $type
     * @param  string  $account
     * @return void
     */
    public function updateAccount(string $id, int $type, string $account): void
    {
        parent::updateV2([
            'user_id' => $id,
            'type' => $type
        ], ['account' => $account]);
    }

    /**
     * 删除账号信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string  $id
     * @param  integer $type
     * @return void
     * 
     * @throws SimpleException
     */
    public function deleteAccount(string $id, int $type): void
    {
        if (Account::where(['user_id' => $id])->count() == 1) {
            throw new SimpleException('会员账号至少需要保留一个');
        }
        tap(parent::find(['user_id' => $id, 'type' => $type]), function (Account $account) {
            $account->delete();
            $this->clearCache();
        });
    }
}
