<?php

namespace App\Services\Backend;

use App\Models\Account;
use App\Models\User;
use App\Enums\User as UserEnum;
use App\Models\UserGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SimpleCMS\Framework\Facades\SystemConfig;
use SimpleCMS\Framework\Services\SimpleService;
use SimpleCMS\Framework\Traits\ExportTemplateTrait;
use SimpleCMS\Framework\Traits\ImportTemplateTrait;

class UserService extends SimpleService
{
    use ExportTemplateTrait, ImportTemplateTrait;

    public ?string $className = User::class;

    /**
     * 获取默认密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return string
     */
    public function getDefaultPassword(): string
    {
        return SystemConfig::getDefaultPassword() ?? env('DEFAULT_PASSWORD', '123456');
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
        if (array_key_exists('group_id', $data) && $data['group_id']) {
            $group_id = $data['group_id'];
            $this->setHas([
                'groups' => function ($query) use ($group_id) {
                    $query->where('id', $group_id);
                }
            ]);
        }
        parent::listQuery($data, $condition);
        $result = parent::list();
        $result['items'] = $result['items']->map(function (User $user) {
            return [
                'id' => $user->id,
                'uid' => $user->uid,
                'avatar' => $user->avatar,
                'nickname' => $user->nickname,
                'name' => optional($user->profile)->name,
                'is_valid' => $user->is_valid,
                'last_login' => $user->last_login,
                'last_ip' => $user->last_ip,
                'register_ip' => $user->register_ip,
                'register_finger' => $user->register_finger,
                'failed_count' => $user->failed_count,
                'created_at' => $user->created_at,
                'email' => $user->accounts->where('type', UserEnum::Email->value)->value('account'),
                'mobile' => $user->accounts->where('type', UserEnum::Mobile->value)->value('account'),
                'account' => $user->accounts->where('type', UserEnum::Account->value)->value('account'),
                'groups' => $user->groups->map(function (UserGroup $userGroup) {
                    return [
                        'value' => $userGroup->id,
                        'name' => $userGroup->name,
                        'icon' => $userGroup->icon
                    ];
                })
            ];
        });
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

        return tap(parent::findById($id),function(User $user){
            return [
                'id' => $user->id,
                'uid' => $user->uid,
                'nickname' => $user->nickname,
                'is_valid' => $user->is_valid,
                'last_login' => $user->last_login,
                'last_ip' => $user->last_ip,
                'failed_count' => $user->failed_count,
                'register_ip' => $user->register_ip,
                'register_finger' => $user->register_finger,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'accounts' => $user->accounts->map(function(Account $account){
                    return [
                        'account' => $account->account,
                        'type' => $account->type,
                        'oauth_id' => $account->oauth_id,
                        'is_valid' => $account->is_valid,
                        'last_login' => $account->last_login,
                        'last_ip' => $account->last_ip,
                        'extra' => $account->extra,
                        'created_at' => $account->created_at
                    ];
                }),
                'profile' => optional($user->profile)
            ];
        })->toArray();
    }

    /**
     * 修改用户密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $id
     * @param  string $password
     * @return void
     */
    public function password(string $id, string $password): void
    {
        parent::setValue($id, 'password', Hash::make($password));
    }
}
