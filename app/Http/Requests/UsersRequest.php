<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->authorize('Edit_Users') || abort(403);
    }


    public function getValidatorInstance(){

        $validator = parent::getValidatorInstance();

      $validator->sometimes('password', 'required|confirmed|min:8', function ($input){
            //вернемо true коли необхідно валідувати password
          //dd($this->route()->getName());
          //dd($this->route()->user->password);
          if(empty($input->password) && $this->route()->getName() != 'users.update'){
              $input->password = $this->route()->user->password;
              return TRUE;
          }

          return !empty($input->password);
      });

        return $validator;
    }

    public function rules()
    {

        $id = (isset($this->route()->parameter('user')->id)) ? $this->route()->parameter('user')->id : '' ;
        //$this->route()->parameter('user')->id - чи існує id юзера коли ми редагуємо то існує.
        //dd($this->route()->parameter('user')->id);

        return [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email,'.$id,
            'login' => 'required|max:20|unique:users,login,'.$id,//тобто якщо існує юзер (при редагуванны) то ігнорується валідація конкретного поля згідно id users

            'role_id' => 'required|integer',
        ];
        //$id- коли ми редагуємо користувача тобто поля email та login задані(існують) та унікаліні
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute не должно быть пустым',
            'unique'    => ':attribute существует. Создайте новый :attribute',
            'confirmed' => 'Пароль не совпадает!'
        ];
    }
}
