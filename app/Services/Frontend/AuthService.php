<?php

namespace App\Services\Frontend;

use App\Models\User;
use App\Models\Account;
use App\Enums\AccountEnum;
use Illuminate\Support\Str;
use App\Packages\Finger\Finger;
use Illuminate\Support\Facades\Hash;
use SimpleCMS\Framework\Facades\SystemConfig;
use SimpleCMS\Framework\Services\SimpleService;

class AuthService extends SimpleService
{

    public ?string $className = Account::class;

    /**
     * OpenId自动登录
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string        $openId
     * @return boolean|array
     */
    public function autoLogin(string $openId): bool|array
    {
        $finger = Finger::getFinger();
        if (!$item = Account::find($openId)) {
            $item = $this->register([
                'account' => $openId,
                'type' => AccountEnum::Wechat->value,
                'oauth_id' => $openId
            ]);
            return (new UserService())->getUserInfo($item, $finger);
        }
        return (new UserService())->getUserInfo($item->user()->first(), $finger);
    }

    /**
     * 注册账号
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array $data
     * @return mixed
     */
    public function register(array $data): mixed
    {
        extract(array_merge([
            'account' => null,
            'type' => 1,
            'password' => null,
            'oauth_id' => null,
            'extra' => null
        ], $data));

        $sql = [
            'account' => $account,
            'type' => $type,
            'oauth_id' => $oauth_id,
            'extra' => $extra,
            'last_ip' => request()->getClientIp(),
            'last_login' => now(),
            'is_valid' => true
        ];
        parent::create($sql);
        $defaultPassword = SystemConfig::getDefaultPassword() ?? env('DEFAULT_PASSWORD', '123456');
        $userSql = [
            'uid' => $this->getNewUid(),
            'nickname' => $extra && array_key_exists('nickname', $extra) ? $extra['nickname'] : Str::random(4) . rand(1000, 9999),
            'password' => Hash::make($password ?? $defaultPassword),
            'is_valid' => true,
            'last_login' => $this->item->last_login,
            'last_ip' => $this->item->last_ip,
            'failed_count' => 0,
            'register_ip' => $this->item->last_ip,
            'register_finger' => Finger::getFinger()
        ];
        $userService = new UserService();
        if ($userService->create($userSql)) {
            $avatar = image_to_base64(public_path('/assets/avatars/avatar-' . rand(1, 24) . '.png'));
            $userService->item->addMediaFromBase64($avatar)->toMediaCollection(User::MEDIA_FILE);
        }
        Account::where('account', $account)->update(['user_id' => $userService->item->id]);
        return $userService->item;
    }

    /**
     * 获取新UID
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return string
     */
    protected function getNewUid(): string
    {
        $max = User::max('uid') ?? 1000;
        return bcadd($max, 1, 0);
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
