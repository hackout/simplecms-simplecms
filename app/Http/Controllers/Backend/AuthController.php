<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Services\Backend\AuthService;
use App\Services\Backend\ManagerService;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\Framework\Attributes\ApiName;
use SimpleCMS\Framework\Http\Requests\SimpleRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;

/**
 * 管理员登录控制器
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class AuthController extends BaseBackendController
{

    /**
     * 登录页面
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return InertiaResponse
     */
    #[ApiName(name: '登录页面')]
    public function login(): InertiaResponse
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * 登录后台
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest                          $request
     * @param  AuthService                      $service
     * @return RedirectResponse|InertiaResponse
     */
    #[ApiName(name: '登录后台')]
    public function auth(SimpleRequest $request, AuthService $service): RedirectResponse|InertiaResponse
    {
        $data = $request->validate([
            'account' => 'required|exists:managers,account',
            'password' => 'required',
            'remember' => 'sometimes|boolean|nullable',
            'code' => 'sometimes|nullable|captcha'
        ], [
            'account.required' => '用户名不能为空',
            'account.exists' => '登录名或密码错误',
            'password.required' => '登录名或密码错误',
            'remember.boolean' => '登录名或密码错误',
            'code.captcha' => '验证码错误'
        ]);
        $result = $service->login((string) $data['account'], (string) $data['password'], (bool) $data['remember']);
        if ($result === true) {
            $request->session()->regenerate();
            (new ManagerService())->login(auth()->id());
            return to_route('backend.dashboard')->with('success', '欢迎回来【' . $data['account'] . '】');
        }
        return $result;
    }

    /**
     * 忘记密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return InertiaResponse
     */
    #[ApiName(name: '忘记密码')]
    public function forget(): InertiaResponse
    {
        return Inertia::render('Auth/Forget');
    }

    /**
     * 退出登录
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return RedirectResponse
     */
    #[ApiName(name: '退出登录')]
    public function logout(): RedirectResponse
    {
        auth('web')->logout();
        return to_route('backend.login')->with('success', '已退出登录，请重新登录账号');
    }

    /**
     * 发送重置密码链接
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  SimpleRequest                          $request
     * @param  AuthService                      $service
     * @return RedirectResponse
     */
    #[ApiName(name: '发送重置密码链接')]
    public function sentResetLink(SimpleRequest $request, AuthService $service): RedirectResponse
    {
        $data = $request->validate([
            'email' => 'required|exists:managers,email',
            'code' => 'sometimes|nullable|captcha'
        ], [
            'email.required' => '电子邮箱不能为空',
            'email.exists' => '电子邮箱地址错误',
            'code.captcha' => '验证码错误'
        ]);
        $result = $service->sentResetLink((string) $data['email']);
        if ($result === true) {
            return back()->with('success', '服务器繁忙请稍后再试');
        }
        return back()->withErrors(['发送密码失败']);
    }

    /**
     * 重置密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string          $code
     * @return InertiaResponse
     */
    #[ApiName(name: '访问重置密码')]
    public function reset(string $code, AuthService $service): InertiaResponse
    {
        return Inertia::render('Auth/Reset', [
            'account' => $service->getReset($code)
        ]);
    }

    /**
     * 重置登录密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string                           $code
     * @param  SimpleRequest                          $request
     * @param  AuthService                      $service
     * @return RedirectResponse
     */
    #[ApiName(name: '重置登录密码')]
    public function resetPassword(string $code, SimpleRequest $request, AuthService $service): RedirectResponse
    {
        $rules = [
            'token' => 'exists:password_reset_tokens,token',
            'password' => 'required|confirmed|between:6,36',
            'code' => 'sometimes|nullable|captcha'
        ];
        $messages = [
            'token.exists' => '校验链接出错',
            'password.required' => '新的密码不能为空',
            'password.confirmed' => '确认密码不相符',
            'password.between' => '登录密码仅支持6-36位字符串',
            'code.captcha' => '验证码校验失败'
        ];
        $validator = Validator::make(array_merge([
            'token' => $code
        ], $request->post()), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = $validator->safe()->only([
            'password'
        ]);
        if (!$service->resetPassword($code, $data['password'])) {
            return back()->withErrors(['重置密码失败']);
        }
        return to_route('login')->with('success', '重置密码成功,请重新登录');
    }

    /**
     * 验证密保邮箱
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string          $code
     * @return InertiaResponse
     */
    #[ApiName(name: '验证密保邮箱')]
    public function verifyEmail(string $code, AuthService $service): InertiaResponse
    {
        return Inertia::render('Auth/Verify', [
            'account' => $service->verifyEmail($code)
        ]);
    }
}
