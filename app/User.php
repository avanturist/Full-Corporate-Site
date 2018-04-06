<?php

namespace Corp;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Corp\Role;
class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //один юзер може мати багато статтей До одного юзера привязані кілька записів
    public function articles(){
        return $this->hasMany('Corp\Article');
    }

    public function roles(){
        return $this->belongsToMany('Corp\Role');
    }

    //перевірка чи у користувача є право на вхід до адмінки тобто роль Admin
    // $permission аргумент може бути 'string' and array()
    //$require- це array
    public function authorize($permissions)
    {
        if(is_array($permissions)){
            return $this->hasAnyPermissions($permissions) || abort(403, 'У Вас нет прав доступа!');
        }

        return $this->hasPermission($permissions);

    }

    //коли Permissions - string
    public function hasPermission($permissions){
        //получаємо коллекцію ролей юзера що аунетифікувався $this->roles
        foreach ($this->roles as $role){
            //роль звязана з конкретним дозволом $role->permiss
            foreach ($role->permiss as $perm){
                if(str_is($permissions, $perm->name)){
                    return TRUE;
                }

            }
        }
    }
    //коли Permissions - array
    public function hasAnyPermissions($permissions){
        foreach ($permissions as $permName){
            $perName = $this->hasPermission($permName);//верне TRUE
            //dump($perName);
        }
        if($perName){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

}



/*
 *
 *  public function authorize($roles, $Permissions){
        if(is_array($roles) || is_array($Permissions)){
            //dd($roles);
            return $this->hasAnyRoles($roles, $Permissions) || abort(401, 'У Вас нет Прав Доступа. <br />Обратитесь к Администратору.');

        }
        return $this->hasRole($roles, $Permissions) || abort(401, 'У Вас нет Прав Доступа. <br />Обратитесь к Администратору.');
    }


public function hasRole($role, $perm){
    $user_role = $this->roles()->where('name', $role)->first();
    //dd($user_role);
    //$permission_role_user
    $role_u = Role::all();
    $permissions_u = $role_u->load('permiss');
    foreach ($permissions_u as $permission){
        if(null !== $permission->permiss()->where('name', $perm)->first()){
            $permission_role_user = $permission->permiss()->where('name', $perm)->first();
        }
    }
    //dd($permission_role_user);
    if(str_is('View_admin', $permission_role_user)){
        return $this->roles()->where('name', $role)->first();
    }
}

* */
