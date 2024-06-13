<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserGroup;
use App\Services\Private\UserGroupService;

class UserGroupObserver
{
    /**
     * Handle the UserGroup "created" event.
     */
    public function created(UserGroup $userGroup): void
    {
        if($userGroup->getOriginal('is_default') != $userGroup->is_default)
        {
            (new UserGroupService())->makeDefaultGroup($userGroup);
        }
    }

    /**
     * Handle the UserGroup "updated" event.
     */
    public function saved(UserGroup $userGroup): void
    {
        if($userGroup->getOriginal('is_default') != $userGroup->is_default)
        {
            (new UserGroupService())->makeDefaultGroup($userGroup);
        }
    }

    /**
     * Handle the UserGroup "updated" event.
     */
    public function updated(UserGroup $userGroup): void
    {
        if($userGroup->getOriginal('is_default') != $userGroup->is_default)
        {
            if($userGroup->is_default)
            {
                (new UserGroupService())->makeDefaultGroup($userGroup);
            }else{
                (new UserGroupService())->checkDefaultGroup($userGroup);
            }
        }
    }

    /**
     * Handle the UserGroup "deleted" event.
     */
    public function deleted(UserGroup $userGroup): void
    {
        $userGroup->users && $userGroup->users()->detach();
        if($userGroup->is_default)
        {
            (new UserGroupService())->newDefaultGroup();
        }
    }

    /**
     * Handle the UserGroup "restored" event.
     */
    public function restored(UserGroup $userGroup): void
    {
        //
    }

    /**
     * Handle the UserGroup "force deleted" event.
     */
    public function forceDeleted(UserGroup $userGroup): void
    {
        //
    }
}
