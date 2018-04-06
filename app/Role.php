<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;
use Corp\User;
use Corp\Permission;
use Illuminate\Support\Facades\Auth;
class Role extends Model
{
    //
    protected $table = 'roles';
    public function users(){
        return $this->belongsToMany('Corp\User');
    }
    public function permiss(){
       return  $this->belongsToMany('Corp\Permission');
    }

///--------------------hasPermission--------
    public function hasPermission($permiss){
        if($permiss){
            return $this->hasPerm($permiss);
        }
        abort(403);
    }

    public function hasPerm($permiss){

        //обходимо коллекц роль-дозволи
        //dd($this->permiss);
        foreach($this->permiss as $per){
            //dd($per->pivot);
           $per_id =  $per->pivot->permission_id;
           //якщо id $permiss співпадає з  permission_id то в даній ролі є відповідна привілегія. Повертаємо TRUE
           if($permiss->id == $per_id){
               return TRUE;
           }
            //інший варіант
              /* if(str_is($permiss->name, $per->name)){
                    return TRUE;
                }*/

        }

    }

    //change permission
    public function savePermissions($data){

        /*$data це список ідентифікаторів привілеїв конкретної ролі*/
        if (!empty($data)){
            /*синхронызуэмо звязаны модель через звязуючу таблицю відповідно до списку ідентифікаторів*/
          $this->permiss()->sync($data);
        }
        else{
            /*detach відвязує привілегії у конкретного користувача*/
            $this->permiss()->detach();
        }
        return TRUE;
    }

    //getAdminRole якщо роль Адин повернемо true
    function getUserRole(){
        $roles = Role::all();
        $user = Auth::user();
        $user_role = $user->roles()->first()->name;
       foreach ($roles as $role){
            if($role->name == $user_role){
                return TRUE;
            }
            else{
                return FALSE;
            }
       }
    }

}


