<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\Backend\ManagerService;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Backend\DashboardService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use SimpleCMS\Framework\Http\Controllers\BackendController as BaseBackendController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use SimpleCMS\Framework\Attributes\ApiName;

/**
 * 管理员个人信息控制器
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class ProfileController extends BaseBackendController
{

    /**
     * 管理员个人信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  ManagerService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '管理员个人信息')]
    public function index(): InertiaResponse
    {
        return Inertia::render('Profile/Index');
    }

    /**
     * 管理员安全邮箱
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  ManagerService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '管理员安全邮箱')]
    public function email(): InertiaResponse
    {
        return Inertia::render('Profile/Email');
    }

    /**
     * 管理员密码安全
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request         $request
     * @param  ManagerService $service
     * @return InertiaResponse
     */
    #[ApiName(name: '管理员密码安全')]
    public function password(): InertiaResponse
    {
        return Inertia::render('Profile/Password');
    }

    /**
     * 管理员修改个人资料
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request                          $request
     * @param  DashboardService                      $service
     * @return RedirectResponse|InertiaResponse
     */
    #[ApiName(name: '管理员修改个人资料')]
    public function update(Request $request, DashboardService $service): RedirectResponse
    {
        $rules = [
            'account' => 'required|unique:managers,account,' . $request->user()->id . ',id',
            'name' => 'required|between:2,36',
            'avatar' => 'sometimes|nullable|image',
            'password' => 'required|current_password:web'
        ];
        $messages = [
            'account.required' => '用户名不能为空',
            'account.unique' => '用户名已存在',
            'name.required' => '姓名不能为空',
            'name.between' => '姓名仅支持2-36个字符',
            'avatar.image' => '头像格式不正确',
            'password.required' => '登录密码不能为空',
            'password.current_password' => '登录密码不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->updateProfile($request->user(),$data);
        return back()->with('success', '保存个人资料成功');
    }

    /**
     * 修改密保邮箱
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request                          $request
     * @param  DashboardService                      $service
     * @return RedirectResponse|InertiaResponse
     */
    #[ApiName(name: '修改密保邮箱')]
    public function updateEmail(Request $request, DashboardService $service): RedirectResponse
    {
        $rules = [
            'email' => 'required|unique:managers,email,' . $request->user()->id . ',id',
            'password' => 'required|current_password:web'
        ];
        $messages = [
            'email.required' => '密保邮箱不能为空',
            'email.unique' => '密保邮箱已存在',
            'password.required' => '登录密码不能为空',
            'password.current_password' => '登录密码不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->updateEmail($request->user(),$data);
        return back()->with('success', '修改密保邮箱成功,请登录邮箱进行验证');
    }

    /**
     * 修改登录密码
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request                          $request
     * @param  DashboardService                      $service
     * @return RedirectResponse|InertiaResponse
     */
    #[ApiName(name: '修改登录密码')]
    public function updatePassword(Request $request, DashboardService $service): RedirectResponse
    {
        $rules = [
            'current_password' => 'required|current_password:web',
            'password' => 'required|confirmed|between:6,36'
        ];
        $messages = [
            'password.required' => '新的密码不能为空',
            'password.confirmed' => '确认新的密码不相符',
            'password.between' => '新的密码仅支持6-36位字符串',
            'current_password.required' => '登录密码不能为空',
            'current_password.current_password' => '登录密码不正确',
        ];
        $data = $request->validate($rules, $messages);
        $service->updatePassword($request->user(),$data);
        return back()->with('success', '修改登录密码成功');
    }

}
