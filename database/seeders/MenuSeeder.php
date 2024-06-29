<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use SimpleCMS\Framework\Models\Menu;

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
                $deepChild = collect($children)->filter(fn($n) => array_key_exists('children', $n))->values();
                if ($deepChild->count()) {
                    $children = collect($children)->filter(fn($n) => !array_key_exists('children', $n))->values();
                }
                if (count($children)) {
                    $item->children()->createMany($children);
                }
                if ($deepChild->count()) {
                    $deepChild->each(function ($child) use ($item) {
                        $_children = $child['children'];
                        unset($child['children']);
                        if ($_child = $item->children()->create($child)) {
                            $_child->children()->createMany($_children);
                        }
                    });
                }
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
                'parent_id' => 0,
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
                'parent_id' => 0,
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
            ],
            [
                'name' => '用户管理',
                'type' => Menu::TYPE_BACKEND,
                'is_valid' => true,
                'is_show' => true,
                'sort_order' => 2,
                'parent_id' => 0,
                'can_delete' => false,
                'icon' => 'IconUsers',
                'url' => [
                    'uri' => 'backend/user/user',
                    'name' => 'backend.user.index',
                    'param' => []
                ],
                'children' => [
                    [
                        'name' => '会员列表',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 3,
                        'can_delete' => false,
                        'icon' => 'IconUsers',
                        'url' => [
                            'uri' => 'backend/user',
                            'name' => 'backend.user.index',
                            'param' => []
                        ]
                    ],
                    [
                        'name' => '会员组',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 2,
                        'can_delete' => false,
                        'icon' => 'IconUsersGroup',
                        'url' => [
                            'uri' => 'backend/user_group',
                            'name' => 'backend.user_group.index',
                            'param' => []
                        ]
                    ],
                    [
                        'name' => '登录账号',
                        'type' => Menu::TYPE_BACKEND,
                        'is_valid' => true,
                        'is_show' => true,
                        'sort_order' => 1,
                        'can_delete' => false,
                        'icon' => 'IconUser',
                        'url' => [
                            'uri' => 'backend/account',
                            'name' => 'backend.account.index',
                            'param' => []
                        ]
                    ]
                ]
            ]
        ];
    }
}
