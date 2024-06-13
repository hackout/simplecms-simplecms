<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\User;
use App\Services\Private\ProfileService;
use App\Services\Private\UserGroupService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        (new ProfileService())->createByUser($user);
        (new UserGroupService())->createByUser($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $user->profile && $user->profile()->delete();
        $user->groups && $user->groups()->detach();
        $user->accounts && $user->accounts->each(fn(Account $account) => $account->delete());
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
