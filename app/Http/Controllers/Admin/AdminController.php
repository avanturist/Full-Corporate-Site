<?php

namespace Corp\Http\Controllers\Admin;

use Corp\User;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Menu;
use Illuminate\Support\Facades\Gate;

class AdminController extends \Corp\Http\Controllers\Controller
{
    //репозитор портфолио
    protected $p_rep;
    //репозитор articles
    protected $a_rep;
    //аутентифік користовачі зберігаємо в обєкті user
    protected $user;
    //репозитор шаблона
    protected $template;
    //репозитор контента
    protected $content;
    //репозитор title
    protected $title;
    //menu
    protected $m_rep;

    protected $vars;
    //category rep
    protected $cat_rep;

    protected $role;
    protected $permission;

    public function __construct()
    {
        $this->middleware(function ($request,$next){
          $this->user = Auth::user();
              return $next($request);
      });


    }

    public function renderOutput(){


        $this->vars = array_add($this->vars, 'title', $this->title);

        //menu
        $menu = $this->getMenu();
        //dd($menu);
        $navigation = view(config('settings.theme').'.Admin.navigation')->with('menu',$menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        //content
        if($this->content){

            $this->vars = array_add($this->vars, 'content', $this->content);
        }
        //-------admin_content--------------
        $admin_content = view(config('settings.theme').'.Admin.admin_content')->render();
        $this->vars = array_add($this->vars, 'content', $admin_content);

        //footer
       $footer = view(config('settings.theme').'.Admin.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);

    }

    public function getMenu(){

            return Menu::make('adminMenu', function ($menu) {
                //якщо у юзера є права доступу до меню сайту показуємо йому дану ссилку
                if(Gate::allows('View_Admin_Menu')){
                    $menu->add('Меню', ['url' => 'admin/menus']);
                }
                $menu->add('Статьи', ['url' => 'admin/articles']);//prefix -admin-page - articles- method-index(because resource)
                $menu->add('Портфолио', ['url' => 'admin/portfolios']);

                $menu->add('Пользователи', ['url'=>'admin/users']);
                $menu->add('Привилегии', ['url' => 'admin/permissions']);
                $menu->add('Выйти', ['route'=>'out', 'class'=>'my_logout']);


            });

    }
}
