<?php

namespace App\Observers;

use App\Models\Account;
use App\Services\Private\UserService;

class AccountObserver
{
    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        if($account->user_id)
        {
            (new UserService())->updateLogin($account);
        }
    }

    /**
     * Handle the Account "updated" event.
     */
    public function saved(Account $account): void
    {
        if($account->user_id)
        {
            (new UserService())->updateLogin($account);
        }
    }
    /**
     * Handle the Account "updated" event.
     */
    public function updated(Account $account): void
    {
        if($account->user_id)
        {
            (new UserService())->updateLogin($account);
        }
    }

    /**
     * Handle the Account "deleted" event.
     */
    public function deleted(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "restored" event.
     */
    public function restored(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "force deleted" event.
     */
    public function forceDeleted(Account $account): void
    {
        //
    }
}
