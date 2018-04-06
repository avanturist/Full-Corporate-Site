<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        //створюємо нову директиву -счетчік
        //@set($i,10)-так визивати її/ $var проста змінна яка буде приймати результат
        Blade::directive('set', function ($var) {
            //$var($i,10)=>розбиваємо Тоді в $name=>$i; $val=>$var
            //print_r($var);
            list($name, $val) = explode(",", $var);
            return "<?php $name = $val;?>";
        });

        //код покаже всі SQL запроси
        DB::listen(function ($query){
            //echo "<h3>$query->sql()</h3>";
        });




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
