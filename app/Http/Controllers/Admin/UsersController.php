<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Repositories\UsersRepository;
use Corp\Role;
use Corp\User;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Corp\Http\Requests\UsersRequest;

class UsersController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    protected $us_rep;

    public function __construct(UsersRepository $us_rep)
    {
        parent::__construct();
        $this->us_rep = $us_rep;
        $this->template = config('settings.theme').'.Admin.User.users';
    }

    public function index()
    {
        if(Gate::denies('Admin_Users')){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);

            return view(config('settings.theme') . '.403')->with($this->vars);
        }
        $this->title = 'Менеджер пользователей';
        $users = $this->getUsers();
        $content = view(config('settings.theme').'.Admin.User.content_user')->with('users', $users)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();

    }

    public function getUsers(){
        $select = ['id', 'name', 'email', 'login'];
        $users = $this->us_rep->get($select,FALSE,FALSE, FALSE);

        if($users){
           $users->load('roles');
        }
        //dd($users);
        return $users;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->title = 'Добавление пользователя';

        $roles = $this->getRoles()->reduce(function ($roles_name, $role){
            $roles_name[$role->id] = $role->name;
            return $roles_name;
        });
        //dd($roles);
        $arr_roles = array('Role:'=>$roles);

        $content = view(config('settings.theme').'.Admin.User.content_form')->with('roles', $arr_roles)->render();
        $this->vars = array_add($this->vars, 'content', $content);


        return $this->renderOutput();

    }

    public function getRoles(){
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
       $result = $this->us_rep->addUser($request);

       if(!empty($result['error']) && is_array($result)){
           return back()->with($result);
       }

       return redirect('/admin')->with($result);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //dd($user);
        $this->title = 'Редактирование пользователя '.$user->name;
        $roles = $this->getRoles()->reduce(function ($role_name, $role){
             $role_name[$role->id] = $role->name;
            return $role_name;
        });

        $content = view(config('settings.theme').'.Admin.User.content_form')->with(['user'=> $user, 'roles'=>$roles])->render();
        $this->vars = array_add($this->vars, 'content', $content);
        return $this->renderOutput();


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $user)
    {

        $result = $this->us_rep->updateUser($request, $user);

        if(!empty($result['error']) && is_array($result)){
            return back()->with($result);

        }

        return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $delete = $this->us_rep->deleteUser($id);
       if(!empty($delete['error']) && is_array($delete)){
           return back()->with($delete);
       }


        return redirect('/admin')->with($delete);

    }
}
