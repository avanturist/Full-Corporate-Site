<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Article;
use Corp\Category;
use Corp\Filter;
use Corp\Portfolio;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfoliosReppository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Menu;
use Corp\Http\Requests\MenusRequest;
class MenusController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct(MenusRepository $m_rep, ArticlesRepository $a_rep, PortfoliosReppository $p_rep)
    {
        parent::__construct();

        $this->m_rep = $m_rep;
        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;
        $this->template = config('settings.theme').'.Admin.Menu.menus';
    }

    public function index()
    {
        //перевірка чи є у користувача дозвіл на перегляд меню
        if(Gate::denies('View_Admin_Menu')){
            abort('403');
        }
        $menus = $this->getIndexMenu();
        //dd($menus->all());
        $content = view(config('settings.theme').'.Admin.Menu.content')->with('menus', $menus)->render();
        $this->vars = array_add($this->vars, 'content', $content);
        $this->title = 'Менеджер меню';
        return $this->renderOutput();

    }
        public function getIndexMenu(){
        $menus = $this->m_rep->get();
            if($menus->isEmpty()){
                return FALSE;
            }
         return  Menu::make('mane_menu', function ($m) use($menus) {
                foreach ($menus as $menu){
                    if($menu->parent == 0){
                        $m->add($menu->title, $menu->path)->id($menu->id);
                    }
                   else{
                        //знайде батьквські пункти
                        if($m->find($menu->parent)){
                            $m->find($menu->parent)->add($menu->title, $menu->path)->id($menu->id);
                        }

                    }


                }
            });

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Add_Menu')){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);
            return view(config('settings.theme').'.403')->with($this->vars);

        }
        $this->title = 'Добавление пункта меню';
        //roots - поверне батьківські пункти меню;
        $select = $this->selectMenu()->roots();
        $select = $select->reduce(function ($arr, $menu){

                $arr[$menu->id] = $menu->title;
                return $arr;
        }, ['0' => 'Родительский пункт меню']);

        /* ------------------------------   формуємо списки для створення ссилок меню ---------------------------------------------*/
        //список категорій меню
        $categoies = Category::select('title', 'id', 'parent_id', 'alias')->get();
        $list = $categoies->reduce(function($arr, $cat){
            if($cat->parent_id == 0){
                $arr[$cat->title] = array();
            }
            else{
               $child = Category::where('id', $cat->parent_id)->first();
               $arr[$child->title][$cat->alias] = $cat->title;
            }
           return $arr;
        },[0=>'Не используется']);

        //список articles
        $articles = \Corp\Article::select('name','alias', 'id')->get();
       $articles = $articles->reduce(function ($arr, $article){
           $arr[$article->alias] = $article->name;
           return $arr;
       }, [0=>'Не используется']);

       //list portfolio
        $portfolios = \Corp\Portfolio::select('id','title','alias')->get();
        $portfolios = $portfolios->reduce(function ($arr, $p){
            $arr[$p->alias] = $p->title;
            return $arr;
        },[0=>'Не используется']);


        //list filters
        $filter = \Corp\Filter::select('id','title','alias')->get();
        $filter = $filter->reduce(function ($arr, $f){
            $arr[$f->alias] = $f->title;
            return $arr;
        },[0=>'Не используется']);

        /* ------------------------------ END LIST -----------------------------------------------------------------------------*/
        $content = view(config('settings.theme').'.Admin.Menu.add_update_menu')
            ->with(['select'=> $select, 'list'=>$list, 'link_article' => $articles, 'link_portf'=>$portfolios, 'link_filter' =>$filter ])->render();
        $this->vars = array_add($this->vars, 'content', $content);
        return $this->renderOutput();
    }

    public function selectMenu(){
        $menus = $this->m_rep->get('*', FALSE, FALSE, FALSE);
        return Menu::make('select_menu', function ($m) use($menus){
            foreach ($menus as $menu){
                if($menu->parent == 0){
                    $m->add($menu->title, $menu->path)->id($menu->id);
                }
                else{
                    if($m->find($menu->parent)){
                        $m->find($menu->parent)->add($menu->title, $menu->path)->id($menu->id);
                    }

                }
            }
        });

    }


    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
       $result = $this->m_rep->addMenu($request);
       if($result){
           return redirect('/admin')->with($result);
       }

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
    public function edit($menu)
    {

        if(Gate::denies('Edit_Menu')){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);
            return view(config('settings.theme').'.403')->with($this->vars);

        }
      /*  $m = $this->selectMenu()->roots();
        $select = $m->reduce(function ($arr, $menu){
            if(!($menu->hasChildren())){
                $arr[$menu->id] = $menu->title;
            }
            else{
                $arr[$menu->id] = $menu->title;
                foreach ($menu->children() as $child) {
                    $arr[$menu->title][$child->id] = $child->title;
               }
            }

            return $arr;
        },[0 =>'Родительский пункт меню']);*/


        $select = $this->selectMenu()->roots();
        $select = $select->reduce(function ($arr, $menu){

            $arr[$menu->id] = $menu->title;
            return $arr;
        }, ['0' => 'Родительский пункт меню']);

        /* ------------------------------   формуємо списки для створення ссилок меню ---------------------------------------------*/
        //список категорій меню
        $categoies = Category::select('title', 'id', 'parent_id', 'alias')->get();
        $list = $categoies->reduce(function($arr, $cat){
            if($cat->parent_id == 0){
                $arr[$cat->title] = array();
            }
            else{
                $child = Category::where('id', $cat->parent_id)->first();
                $arr[$child->title][$cat->alias] = $cat->title;
            }
            return $arr;
        },[0=>'Не используется']);

        //список articles
        $articles = \Corp\Article::select('name','alias', 'id')->get();
        $articles = $articles->reduce(function ($arr, $article){
            $arr[$article->alias] = $article->name;
            return $arr;
        }, [0=>'Не используется']);

        //list portfolio
        $portfolios = \Corp\Portfolio::select('id','title','alias')->get();
        $portfolios = $portfolios->reduce(function ($arr, $p){
            $arr[$p->alias] = $p->title;
            return $arr;
        },[0=>'Не используется']);


        //list filters
        $filter = \Corp\Filter::select('id','title','alias')->get();
        $filter = $filter->reduce(function ($arr, $f){
            $arr[$f->alias] = $f->title;
            return $arr;
        },[0=>'Не используется']);

        /* ------------------------------ END LIST -----------------------------------------------------------------------------*/

        $content = view(config('settings.theme').'.Admin.Menu.add_update_menu')
            ->with(['menu'=>$menu, 'select'=> $select, 'list'=>$list, 'link_article' => $articles, 'link_portf'=>$portfolios, 'link_filter' =>$filter ])->render();
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
    public function update(MenusRequest $request, $menu)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('Delete_Menu')){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);
            return view(config('settings.theme').'.403')->with($this->vars);

        }
    }
}
