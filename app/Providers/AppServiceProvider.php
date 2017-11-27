<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Jblv\Admin\Auth\Database\Administrator;
use Jblv\Admin\Auth\Database\Menu;
use Jblv\Admin\Auth\Database\Permission;
use Jblv\Admin\Auth\Database\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $callback = function () {
//            return false;
//        };
//
//        Menu::saving($callback);
//        Role::saving($callback);
//        Permission::saving($callback);
//        Administrator::saving($callback);
//
//        Menu::deleting($callback);
//        Role::deleting($callback);
//        Permission::deleting($callback);
//        Administrator::deleting($callback);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
