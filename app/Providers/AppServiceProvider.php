<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bindObservers();
    }

    /**
     * 加载模型事件
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    protected function bindObservers(): void
    {
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\UserGroup::observe(\App\Observers\UserGroupObserver::class);
        \App\Models\Account::observe(\App\Observers\AccountObserver::class);
        \App\Models\Manager::observe(\App\Observers\ManagerObserver::class);
    }
}
