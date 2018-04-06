<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 26.03.2018
 * Time: 15:02
 */

namespace Corp\Repositories;


use Corp\Permission;
use Corp\Role;
use Illuminate\Support\Facades\Gate;
class PermissionsRepository extends Repository
{
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function changePermissions($request){
        if(Gate::denies('change', $this->model)){
            abort(403);
        }

        //$requst це масив в якому ключі це ролі а значення це permissions
        $data = $request->except('_token');
        //dd($data);
        $roles = Role::all();

       foreach($roles as $role){
           //$role_name = $role->name;
           /*  для кожної ролі формуємо масив привілегії відповідно до id ролі , якщо вони існують то зберігаємо їх */
           if(isset($data[$role->id])){
              $role->savePermissions($data[$role->id]);

           }
           else{
               /*якщо $data empty тобто для юрера не відмічаний жодних checkbox то перед порожній масив */
                $role->savePermissions([]);

           }

       }
        return ['status' => 'Права пользователя -  Обновлены!'];

    }


}