<?php

namespace App\Services\Private;

use App\Models\User;
use App\Models\UserGroup;
use SimpleCMS\Framework\Services\SimpleService;

class UserGroupService extends SimpleService
{
    public ?string $className = UserGroup::class;

    public function createByUser(User $user):void
    {
        $defaultGroup = parent::find(['is_default'=>true]);
        if($defaultGroup)
        {
            $defaultGroup->users()->attach($user->id);
        }
    }

    /**
     * 取消其他默认值
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  UserGroup $userGroup
     * @return void
     */
    public function makeDefaultGroup(UserGroup $userGroup): void
    {
        if ($userGroup->is_default) {
            parent::updateV2([
                ['id', '!=', $userGroup->id]
            ], [
                'is_default' => false
            ]);
        }
    }

    public function checkDefaultGroup(UserGroup $userGroup):void
    {
        if(!UserGroup::where('id','!=',$userGroup->id)->where('is_default',true)->count())
        {
            $this->newDefaultGroup();
        }
    }

    /**
     * 检查默认
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    public function newDefaultGroup(): void
    {
        $firstGroup = UserGroup::first();
        if($firstGroup)
        {
            parent::setValue($firstGroup->id, 'is_default', true);
        }
    }
}