<?php

namespace Corp\Providers;



use Corp\Menu;
use function foo\func;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Corp\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        //пропишемо загальне правило для параметрів що передаються
        //а саме для параметрыв (alias, cat_alias, filter ) пропишемо правило регулярного виразу

        Route::pattern('cat_alias','[a-z]+');
        Route::pattern('filter','[a-z-]+');
        Route::pattern('alias','[a-z-0-9]+');

        parent::boot();

        //привяжемо параметр alias до класу моделі Articles (внедряєм зависимость)
       Route::bind('article', function ($value) {
          return \Corp\Article::where('alias', $value)->first();
       });
        Route::bind('portfolio', function ($value) {
            return (\Corp\Portfolio::where('alias', $value)->first());
        });


        Route::bind('user', function ($value){
          return \Corp\User::find($value);//модель пользователя до редагується для валідації  (параметр users передаємо в UserRequest)
       });

        //привязка menu до моделы Menu
        Route::bind('menu', function ($value){
           return \Corp\Menu::find($value);
        });


    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
