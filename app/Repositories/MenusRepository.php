<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 21.02.2018
 * Time: 14:13
 */

namespace Corp\Repositories;

use Corp\Menu;
use Illuminate\Support\Facades\Gate;
class MenusRepository extends Repository
{
    public function __construct(Menu $menu)
    {
        return $this->model = $menu;
    }


    public function addMenu($request){
        if(Gate::denies('save', $this->model)){
            abort(403);
        }
        $data = $request->except('_token');
        if($data){
            $new = $this->model->fill($data);
            $new->save();
            return ['status' => 'Добавлен новый пункт меню'];
        }

    }


}