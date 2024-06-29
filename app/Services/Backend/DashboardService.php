<?php

namespace App\Services\Backend;

use DB;
use Str;
use Carbon\Carbon;
use App\Models\Manager;
use App\Mail\ManagerVerify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use SimpleCMS\Framework\Services\SimpleService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DashboardService extends SimpleService
{
    protected Manager|null $account;
    public ?string $className = Manager::class;

    /**
     * 修改个人资料
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Manager $manager
     * @param  array   $data
     * @return void
     */
    public function updateProfile(Manager $manager, array $data): void
    {
        $sql = [
            'account' => trim($data['account']),
            'name' => trim($data['name']),
        ];
        $manager->fill($sql);
        if ($manager->save()) {
            if (array_key_exists('avatar', $data) && $data['avatar'] instanceof UploadedFile) {
                if ($manager->avatar) {
                    $manager->getFirstMedia(Manager::MEDIA_AVATAR)->delete();
                }
                $manager->addMedia($data['avatar'])->toMediaCollection(Manager::MEDIA_AVATAR);
            }
        }
    }

    /**
     * 修改密保邮箱
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Manager $manager
     * @param  array   $data
     * @return void
     */
    public function updateEmail(Manager $manager, array $data): void
    {
        $manager->fill([
            'email' => $data['email'],
            'email_verified_at' => null
        ]);
        if ($manager->save()) {
            $tableName = 'password_reset_tokens';
            $now = Carbon::now();
            $token = Str::uuid();
            $sql = [
                'token' => $token,
                'created_at' => $now
            ];
            if ($already = DB::table($tableName)->where(['email' => $data['email']])->first()) {
                DB::table($tableName)->where('email', $data['email'])->update($sql);
            } else {
                DB::table($tableName)->insert(array_merge(['email' => $data['email']], $sql));
            }
            Mail::to($data['email'])->send(new ManagerVerify($data['email'], $token));
        }
    }

    /**
     * 修改登录密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Manager $manager
     * @param  array   $data
     * @return void
     */
    public function updatePassword(Manager $manager, array $data): void
    {
        $password = Hash::make($data['password']);
        $manager->fill(['password' => $password]);
        $manager->save();
    }

}
