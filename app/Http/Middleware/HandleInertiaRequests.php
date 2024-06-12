<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use App\Models\Manager;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleCMS\Framework\Models\Role;
use SimpleCMS\Framework\Facades\Menu;
use SimpleCMS\Framework\Attributes\ApiName;
use Illuminate\Database\Eloquent\Collection;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $title = $this->getTitle($request);
        $menus = $this->getMenus($request);
        return array_merge(parent::share($request), [
            'manager' => auth('web')->user(),
            'title' => $title,
            'routeName' => $request->route()->getName(),
            'menus' => $menus,
            'historyMenu' => Menu::getMenuTreeByRoute($request->route())
        ]);
    }

    /**
     * 获取菜单
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @return Collection|\Illuminate\Support\Collection
     */
    protected function getMenus(Request $request): Collection|\Illuminate\Support\Collection
    {
        $roles = [];
        tap($request->user(), function (?Manager $manager) use (&$roles) {
            if (!$manager)
                return [];
            if ($manager->is_super) {
                $roles = ['*'];
            } else {
                $roleList = DB::table('roles_more')->where([
                    'model_type' => Manager::class,
                    'model_id' => $manager->id
                ])->get()->pluck('role_id');
                if ($roleList) {
                    $list = Role::whereIn('id', $roleList)->get()->pluck('routes')->toArray();
                    $roles = array_unique(Arr::collapse($list));
                } else {
                    $roles = [];
                }
            }
        });
        return Menu::backendMenu($roles);
    }

    /**
     * 获取页面标题
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  Request $request
     * @return string
     */
    protected function getTitle(Request $request): string
    {
        $controllerName = $request->route()->getControllerClass();
        $actionName = $request->route()->getActionMethod();
        $name = 'SimpleCMS';
        if (\method_exists($controllerName, $actionName)) {
            $reflectionMethod = new \ReflectionMethod($controllerName, $actionName);
            $attributes = $reflectionMethod->getAttributes(ApiName::class);
            foreach ($attributes as $attribute) {
                if ($attribute->getName() === ApiName::class) {
                    $name = $attribute->getArguments()['name'];
                }
            }
        }
        return $name;
    }
}
