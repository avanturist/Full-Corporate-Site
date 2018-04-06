<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//аутентифікацію

Route::get('/login', ['uses'=>'Auth\LoginController@showLoginForm', 'as'=>'enter_to_admin']);
Route::post('/login', ['uses'=>'Auth\LoginController@login']);
Route::get('logout', ['uses'=>'Auth\LoginController@logout', 'as'=>'out']);

//реестрация
Route::get('/registration', ['uses'=>'Auth\RegisterController@showRegistrationForm', 'as'=>'registr']);
Route::post('/registration', ['uses'=>'Auth\RegisterController@register']);
//adminka

Route::group(['prefix'=>'admin', 'middleware'=>'auth'],function (){

    Route::get('/', ['uses'=>'Admin\IndexController@index','as'=>'adminka']);
    //admin/articles
    Route::resource('/articles', 'Admin\ArticlesController');
    //admin/portfolio
    Route::resource('/portfolios', 'Admin\PortfolioController');
    //admin/menus
    Route::resource('/menus', 'Admin\MenusController');
    //admin/users
    Route::resource('/users', 'Admin\UsersController');
    //admin/permissions
    Route::resource('/permissions', 'Admin\PermissionsController');

});

Route::resource('/', 'IndexController', [
                                        'only' => ['index'],
                                        'names'=> ['index' => 'home']
                                                ]);

Route::resource('portfolios', 'PortfolioContoller', [
                                                    'parameters' => ['portfolios'=>'alias']
                                                    ]);

Route::resource('articles', 'ArticlesController', [
                                                    'parameters' =>['articles'=>'alias']
                                                    ]);
Route::get('articles/cat/{cat_alias?}', ['uses'=>'ArticlesController@index', 'as'=>'articlesCat']);


Route::resource('comment', 'CommentController', [
                                                    'only' => ['store'],
                                                ]);

Route::group(['prefix'=>'/portfolios/filter'], function (){
    Route::get('/{filter}' ,['uses'=>'FilterPortfolioController@index', 'as'=>'filterportfolio'] );
});



Route::match(['get', 'post'], '/contacts' , ['uses'=>'ContactController@index', 'as'=>'contact']);



