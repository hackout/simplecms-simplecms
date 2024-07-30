<?php

namespace App\Services\Backend;

use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use SimpleCMS\Framework\Models\Menu;
use SimpleCMS\Framework\Services\SimpleService;
use SimpleCMS\Framework\Exceptions\SimpleException;

class MenuService extends SimpleService
{

    public string $className = Menu::class;

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
            'keyword' => ['search', ['name', 'code']],
            'parent_id' => 'eq',
            'type' => 'eq'
        ];
        $data['parent_id'] = 0;
        parent::listQuery($data, $condition);
        $result = parent::list();
        $result['items'] = $result['items']->map(function (Menu $menu) {
            return [
                'id' => $menu->id,
                'name' => $menu->name,
                'url' => $menu->url,
                'type' => $menu->type,
                'can_delete' => $menu->can_delete,
                'icon' => $menu->icon,
                'is_valid' => $menu->is_valid,
                'is_show' => $menu->is_show,
                'sort_order' => $menu->sort_order,
                'parent_id' => $menu->parent_id,
                'children' => $menu->children->map(function (Menu $menu) {
                    return [
                        'id' => $menu->id,
                        'name' => $menu->name,
                        'type' => $menu->type,
                        'can_delete' => $menu->can_delete,
                        'url' => $menu->url,
                        'icon' => $menu->icon,
                        'is_valid' => $menu->is_valid,
                        'is_show' => $menu->is_show,
                        'sort_order' => $menu->sort_order,
                        'parent_id' => $menu->parent_id,
                        'children' => $menu->children->map(function (Menu $menu) {
                            return [
                                'id' => $menu->id,
                                'name' => $menu->name,
                                'type' => $menu->type,
                                'can_delete' => $menu->can_delete,
                                'url' => $menu->url,
                                'icon' => $menu->icon,
                                'is_valid' => $menu->is_valid,
                                'is_show' => $menu->is_show,
                                'sort_order' => $menu->sort_order,
                                'parent_id' => $menu->parent_id
                            ];
                        })
                    ];
                })
            ];
        });
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
        $filters = ["sanctum.csrf-cookie", "ignition.healthCheck", "ignition.executeSolution", "ignition.updateConfig"];
        $routeAlias = collect(app('router')->getRoutes()->getRoutesByName())
            ->reject(function (Route $route) {
                return Str::startsWith($route->getName(), 'generated::');
            })
            ->partition(function ($route) {
                return $route->isFallback;
            })->last()->reject(function (Route $route) use ($filters) {
                return in_array($route->getName(), $filters) || head($route->methods) != 'GET';
            })->map(function (Route $route) {
                return [
                    'name' => $route->uri,
                    'type' => Str::startsWith($route->getName(), 'backend') ? 1 : 2,
                    'value' => $route->uri,
                    'url' => [
                        'name' => $route->getName(),
                        'param' => Str::of($route->uri)->matchAll('/\{(.*)\}/')->toArray(),
                        'uri' => $route->uri
                    ]
                ];
            });
        return $routeAlias->values();
    }

    /**
     * 添加菜单
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array   $data
     * @return boolean
     */
    public function createByUri(array $data): bool
    {
        $sql = collect($data);
        $uri = $sql->pull('uri');
        $routeList = $this->getRouteList();
        $url = $routeList->filter(fn($n) => $n['value'] == $uri)->first();
        if (!$url) {
            throw new SimpleException("链接参数错误");
        }
        $sql->put('url', $url['url']);
        $sql->put('can_delete',true);
        return parent::create($sql->toArray());
    }

    /**
     * 编辑菜单
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  integer|string $id
     * @param  array          $data
     * @return boolean
     */
    public function updateByUri(int|string $id, array $data): bool
    {
        $sql = collect($data);
        $uri = $sql->pull('uri');
        $routeList = $this->getRouteList();
        $url = $routeList->filter(fn($n) => $n['value'] == $uri)->first();
        if (!$url) {
            throw new SimpleException("链接参数错误");
        }
        $sql->put('url', $url['url']);
        return parent::update($id, $sql->toArray());
    }

    /**
     * 批量修改信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array $data
     * @return void
     */
    public function quickSave(array $data):void
    {
        $data = collect($data['items']);
        parent::quick('is_valid',$data->pluck('is_valid','id')->toArray());
        parent::quick('is_show',$data->pluck('is_show','id')->toArray());
        parent::quick('sort_order',$data->pluck('sort_order','id')->toArray());
    }
}
