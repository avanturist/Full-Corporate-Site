<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Repositories\PermissionsRepository;
use Corp\Repositories\RolesRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
class PermissionsController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $perm_rep;
    protected $role_rep;

    public function __construct(PermissionsRepository $permis, RolesRepository $role)
    {
        parent::__construct();
        $this->perm_rep = $permis;
        $this->role_rep = $role;
        $this->template = config('settings.theme').'.Admin.Permissions.permissions';

    }

    public function index()
    {
        // чи має юзер права на редагування привілегій
        if(Gate::denies('Edit_Users')){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);
            return view(config('settings.theme').'.403')->with($this->vars);
        }

        $this->title = 'Менеджер привилегий';
        $roles = $this->getRoles();
        $permissions = $this->getPermissions();


        $content = view(config('settings.theme').'.Admin.Permissions.contentPerm')->with(['roles'=>$roles, 'permiss'=>$permissions]);
        $this->vars = array_add($this->vars, 'content', $content);
        return $this->renderOutput();
    }

    public function getRoles(){
        return  $this->role_rep->get(['name','id'], FALSE, FALSE, FALSE);

    }
    public function getPermissions(){
        return  $this->perm_rep->get(['name','id'], FALSE, FALSE, FALSE);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $result = $this->perm_rep->changePermissions($request);

        if(!empty($result['error']) && is_array($result)){
            return back()->with($result)->withInput();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
