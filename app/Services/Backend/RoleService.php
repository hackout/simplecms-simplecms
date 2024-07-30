<?php

namespace App\Services\Backend;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use SimpleCMS\Framework\Models\Role;
use SimpleCMS\Framework\Attributes\ApiName;
use SimpleCMS\Framework\Services\SimpleService;

class RoleService extends SimpleService
{
    public string $className = Role::class;

    public function getRoleOptions(): array
    {
        return parent::getAll([
            'id as value',
            'name'
        ])->toArray();
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
            'keyword' => ['search', ['id', 'name', 'description']],
            'type' => 'eq'
        ];
        parent::listQuery($data, $condition);
        $result = parent::list();
        return $result;
    }

    /**
     * 获取路由列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return Collection
     */
    public function getRouteList(): Collection
    {
        $hiddens = [
            'backend.dashboard',
            'backend.logout',
            'backend.dashboard.profile',
            'backend.dashboard.profile.email',
            'backend.dashboard.profile.password',
            'backend.dashboard.profile_update',
            'backend.dashboard.profile.email_update',
            'backend.dashboard.profile.password_update',
            'backend.login',
            'backend.login.auth',
            'backend.forget',
            'backend.forget.email',
            'backend.reset',
            'backend.reset.password',
            'backend.verify.email'
        ];
        $routeAlias = collect(app('router')->getRoutes()->getRoutesByName())
            ->filter(function (Route $route) use ($hiddens) {
                return strpos($route->getName(), 'backend.') === 0 && !in_array($route->getName(), $hiddens);
            })->map(function (Route $route) {
                $controllerName = $route->getControllerClass();
                $actionName = $route->getActionMethod();
                $name = null;
                if (\method_exists($controllerName, $actionName)) {
                    $reflectionMethod = new \ReflectionMethod($controllerName, $actionName);
                    $attributes = $reflectionMethod->getAttributes(ApiName::class);
                    $name = $controllerName . '@' . $actionName;
                    foreach ($attributes as $attribute) {
                        if ($attribute->getName() === ApiName::class) {
                            $name = $attribute->getArguments()['name'];
                        }
                    }
                }
                return [
                    'value' => $route->getName(),
                    'name' => $name
                ];
            })->filter(fn($n) => !empty ($n['name']))->values();
        return $routeAlias->values();
    }

    /**
     * 添加角色
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array   $data
     * @param  array   $mediaFields
     * @return boolean
     */
    public function create(array $data, array $mediaFields = []): bool
    {
        $data['routes'] = explode(',', $data['routes']);
        return parent::create($data);
    }

}