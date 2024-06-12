<?php

namespace Database\Seeders;

use Hash;
use SimpleCMS\Framework\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getList();
        foreach ($data as $sql) {
            $_sql = collect($sql);
            $children = $_sql->pull('children');
            if ($item = Menu::create($_sql->toArray())) {
                $item->children()->createMany($children->toArray());
            }
        }
    }

    public function getList()
    {
        return [
            [
                'name' => '系统设置',
                'type' => Menu::TYPE_BACKEND,
                'is_valid' => true,
                'is_show' => true,
                'sort_order' => 0,
                'can_delete' => false,
                'icon' => 'IconSettings',
                'url' => [
                        'uri' => 'backend/system',
                        'name' => 'backend.system',
                        'param' => []
                    ],
                'children' => [
                    [
                        'name' => '系统参数',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 4,
                        'can_delete' => false,
                        'icon' => 'IconSettingsCog',
                        'url' => [
                                'uri' => 'backend/system',
                                'name' => 'backend.system',
                                'param' => []
                            ]
                    ],
                    [
                        'name' => '菜单管理',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 3,
                        'can_delete' => false,
                        'icon' => 'IconServerCog',
                        'url' => [
                                'uri' => 'backend/system/menu',
                                'name' => 'backend.menu',
                                'param' => []
                            ]
                    ],
                    [
                        'name' => '字典管理',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 2,
                        'can_delete' => false,
                        'icon' => 'IconTableOptions',
                        'url' => [
                                'uri' => 'backend/system/dict',
                                'name' => 'backend.dict',
                                'param' => []
                            ]
                    ],
                    [
                        'name' => '系统缓存',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 1,
                        'can_delete' => false,
                        'icon' => 'IconReplace',
                        'url' => [
                                'uri' => 'backend/system/cache',
                                'name' => 'backend.system_cache',
                                'param' => []
                            ]
                    ]
                ]
            ],
            [
                'name' => '管理人员',
                'type' => Menu::TYPE_BACKEND,
                'is_valid' => true,
                'is_show' => true,
                'sort_order' => 1,
                'can_delete' => false,
                'icon' => 'IconUsersGroup',
                'url' => [
                        'uri' => 'backend/manager',
                        'name' => 'backend.manager',
                        'param' => []
                    ],
                'children' => [
                    [
                        'name' => '管理员列表',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 3,
                        'can_delete' => false,
                        'icon' => 'IconUsers',
                        'url' => [
                                'uri' => 'backend/manager',
                                'name' => 'backend.manager',
                                'param' => []
                            ]
                    ],
                    [
                        'name' => '角色管理',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 2,
                        'can_delete' => false,
                        'icon' => 'IconCircles',
                        'url' => [
                                'uri' => 'backend/role',
                                'name' => 'backend.role',
                                'param' => []
                            ]
                    ],
                    [
                        'name' => '请求日志',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 1,
                        'can_delete' => false,
                        'icon' => 'IconLogs',
                        'url' => [
                                'uri' => 'backend/manager/log',
                                'name' => 'backend.manager_log',
                                'param' => []
                            ]
                    ]
                ]
            ]
        ];
    }
}
