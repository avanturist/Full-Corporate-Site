<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 21.03.2018
 * Time: 19:19
 */

namespace Corp\Repositories;


use Corp\User;
use Corp\Role;
use Illuminate\Support\Facades\Gate;
class UsersRepository extends Repository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function addUser($request){
       if(Gate::denies('create', $this->model)){
           abort(403);
       }

       $data = $request->all();

       $user = new $this->model;
       $user->name = $data['name'];
       $user->email = $data['email'];
       $user->login = $data['login'];
       $user->password = bcrypt($data['password']);
       $user->save();

       if($user){
           $user->roles()->attach($data['role_id']);
        }
        return ['status'=>'Пользователь добавлен!'];

    }

    public function updateUser($request, $user){

        if(Gate::denies('edit' , $this->model)) {

            abort(403);
        }
            //dd($user->roles);

         $data = $request->all();

        if(isset($data['password'])){
             $data['password'] = bcrypt($data['password']);
         }

         $user->fill($data)->update();
         $user->roles()->sync($data['role_id']);

         return ['status'=>'Пользователь обновлен!'];


    }

    public function deleteUser($user){

        if(Gate::denies('delete', $this->model)){
            abort(403);
        }

        //видаляємо всі ролі юзера
            $user->roles()->detach();

           if($user->delete()){
               return ['status'=>'Пользователь удален!'];
           }



    }
}