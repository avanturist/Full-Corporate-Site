<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Role;
use Corp\User;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class IndexController extends AdminController
{
    //

    public function __construct()
    {

        parent::__construct();

        $this->template = config('settings.theme').'.Admin.index';
    }

    public function index(){
        //перевіряємо чи заборонено користувачу виконання дозволу View_Admin якщо ні, то вернем TRUE
        //якщо заборонено вернем abort

        if(Gate::denies('View_Admin')){
            abort(401);
        }


        $this->title = 'Панель Администратора';

        return $this->renderOutput();
    }
}
