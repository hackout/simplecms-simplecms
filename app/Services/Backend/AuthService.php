<?php

namespace App\Services\Backend;

use DB;
use Str;
use Carbon\Carbon;
use App\Models\Manager;
use App\Mail\ManagerForgetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use SimpleCMS\Framework\Services\SimpleService;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthService extends SimpleService
{
    protected Manager|null $account;
    public ?string $className = Manager::class;

    /**
     * 后台登录
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string                   $account
     * @param  string                   $password
     * @param  boolean                  $remember
     * @return boolean|RedirectResponse
     */
    public function login(string $account, string $password, bool $remember = false): bool|RedirectResponse
    {
        if (!Auth::attempt(['account' => $account, 'password' => $password, 'is_valid' => true], $remember)) {
            return back()->withErrors('账号密码错误');
        }
        return true;
    }


    /**
     * 发送修改密码链接
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string                   $email
     * @return bool
     */
    public function sentResetLink(string $email): bool
    {
        $tableName = 'password_reset_tokens';
        $now = Carbon::now();
        $token = Str::uuid();
        $sql = [
            'token' => $token,
            'created_at' => $now
        ];
        if (Manager::where('email', $email)->whereNull('email_verified_at')->first()) {
            return false;
        }
        if ($already = DB::table($tableName)->where(['email' => $email])->first()) {
            $date = Carbon::parse($already->created_at);
            if ($date->gt($now->clone()->subMinutes(15))) {
                return false;
            }
            if (!DB::table($tableName)->where('email', $email)->update($sql)) {
                return false;
            }
        } else {
            if (!DB::table($tableName)->insert(array_merge(['email' => $email], $sql))) {
                return false;
            }
        }
        Mail::to($email)->send(new ManagerForgetPassword($email, $token));
        return true;
    }

    /**
     * 查询找回密码Token
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string $token
     * @return array
     */
    public function getReset(string $token): array
    {
        $tableName = 'password_reset_tokens';
        $now = Carbon::now();
        $already = DB::table($tableName)->where(['token' => $token])->first() ?? [];
        if (empty($already)) {
            return [];
        }
        $date = Carbon::parse($already->created_at);
        if ($date->gt($now->clone()->subMinutes(15))) {
            return [];
        }
        return [
            'email' => $already->email,
            'token' => $already->token
        ];
    }

    /**
     * 重置登录密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string  $token
     * @param  string  $password
     * @return boolean
     */
    public function resetPassword(string $token, string $password): bool
    {
        $tableName = 'password_reset_tokens';
        $now = Carbon::now();
        $already = DB::table($tableName)->where(['token' => $token])->first() ?? [];
        if (empty($already)) {
            return false;
        }
        $date = Carbon::parse($already->created_at);
        if ($date->gt($now->clone()->subMinutes(15))) {
            return false;
        }
        $password = Hash::make($password);
        $reset = parent::updateV2([
            'email' => $already->email
        ], ['password' => $password]);
        if($reset)
        {
            DB::table($tableName)->where('email',$already->email)->delete();
        }
        return $reset;
    }

    /**
     * 验证密保邮箱
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string  $token
     * @return array
     */
    public function verifyEmail(string $token): array
    {
        $tableName = 'password_reset_tokens';
        $now = Carbon::now();
        $already = DB::table($tableName)->where(['token' => $token])->first() ?? [];
        if (empty($already)) {
            return [];
        }
        $verify = parent::updateV2([
            'email' => $already->email
        ], ['email_verified_at' => $now]);
        if($verify)
        {
            DB::table($tableName)->where('email',$already->email)->delete();
        }
        return [
            'email' => $already->email,
            'token' => $already->token
        ];
    }
}
