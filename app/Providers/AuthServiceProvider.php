<?php

namespace Corp\Providers;

use Corp\Policies\RolePolicy;
use function foo\func;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

        'Corp\Article' => 'Corp\Policies\ArticlePolicy',
        'Corp\User'    => 'Corp\Policies\UserPolicy',
        'Corp\Portfolio'    => 'Corp\Policies\PortfolioPolicy',
        'Corp\Permission'   => 'Corp\Policies\PermissionPolicy',
        'Corp\Menu'   => 'Corp\Policies\MenuPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Gate::define('View_Admin', 'RolePolicy@updateqwqwq');
        //перевірка на правило View_Admin ($user-корист який аутентифікувся на сайті)

      Gate::define('View_Admin', function ($user) {
           return $user->authorize('View_Admin');//метод описаний в моделі User
        });
        //Edit_Article
       Gate::define('Edit_Article', function ($user) {
            return $user->authorize('Edit_Article');//метод описаний в моделі User
        });

       Gate::define('View_Admin_Menu', function ($user){
           return $user->authorize('View_Admin_Menu');
       });

       Gate::define('Admin_Users', function ($user){
          return $user->authorize('Admin_Users');
       });

       //Edit_Users
        Gate::define('Edit_Users', function ($user){
            return $user->authorize('Edit_Users');
        });
        //Delete_Users
        Gate::define('Delete_Users',function ($user){
           return $user->authorize('Delete_Users');
        });
        Gate::define('Add_Portfolio', function ($user){
            return $user->authorize('Add_Portfolio');
        });
        //Edit_Portfolio - не використувуючи Policy, на пряму перевірка permission
        Gate::define('Edit_Portfolio', function ($user){
                return $user->authorize('Edit_Portfolio');
        });
        Gate::define("Delete_Portfolio", function ($user){
           return $user->authorize('Delete_Portfolio');
        });
        //Edit_Permissions
        Gate::define('Edit_Permissions',function($user){
            return $user->authorize('Edit_Permissions');
        });
        //MENUS
        Gate::define('Add_Menu', function ($user){
           return $user->authorize('Add_Menu');
        });
        Gate::define('Edit_Menu', function ($user){
            return $user->authorize('Add_Menu');
        });
        Gate::define('Delete_Menu', function ($user){
            return $user->authorize('Add_Menu');
        });
    }
}
