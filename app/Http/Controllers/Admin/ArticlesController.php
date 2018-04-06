<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Article;
use Corp\Category;
use Corp\Http\Requests\ArticlesRequest;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\CategoryRepository;
use Validator;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Corp\User;

class ArticlesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ArticlesRepository $a_rep, CategoryRepository $cat_rep)
    {
        parent::__construct();

        $this->a_rep = $a_rep;
        $this->cat_rep = $cat_rep;
        $this->template = config('settings.theme').'.Admin.Article.articles';
    }

    public function index()
    {
        $this->title = 'Менеджер Статтей';
        $allArticles = $this->a_rep->get('*', FALSE, FALSE, FALSE);
        //dd($allArticles);
        $view_article = view(config('settings.theme').'.Admin.Article.all_art_content')->with('allArt', $allArticles)->render();
        $this->vars = array_add($this->vars, 'content', $view_article);

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //class:Politicy
        if(Gate::denies('save', new \Corp\Article)) {
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);

            return view(config('settings.theme') . '.403')->with($this->vars);

        }
            $this->title = 'Добавить новый материал';


            //формуємо список готових категорій який передамо в select
            $select = ['id', 'title', 'alias', 'parent_id'];
            $category = $this->cat_rep->get($select, FALSE, FALSE, FALSE);

            //двохрівневий масив категорій
            $list = array();
            foreach ($category as $cat) {
                if ($cat->parent_id == 0) {
                    $list[$cat->title] = array();
                } else {
                    $list[$cat->where('id', $cat->parent_id)->first()->title][$cat->id] = $cat->title;
                }
            }
            //dd($list);
            $this->template = config('settings.theme') . '.Admin.Article.form';
            $form = view(config('settings.theme') . '.Admin.Article.form_content')->with('lists', $list)->render();
            $this->vars = array_add($this->vars, 'content', $form);
            return $this->renderOutput();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlesRequest $request)
    {
        $result = $this->a_rep->addArticle($request);
        //dump($result);
        //якщо в result є помилки валідації то
        if(is_array($result) && !empty($result['error'])){
            //dd($result);
            return back()->with($result);
        }

        // верне result з данними в сессії
        //dd($result);


        return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alias)
    {
        //


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //dd($article);
        if(Gate::denies('edit', new \Corp\Article)){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);
            return view(config('settings.theme').'.403')->with($this->vars);
        }
        $this->title = 'Страница редактирования';
        //$article = $this->a_rep->one($alias);//можна зробити виборку по alias

        //розбиваємо json img
        if($article){
            $article->img = json_decode($article->img);
        }
        //dd($article);
        //Дістаємо категорії
        $categories = Category::all();
        $list = array();
        foreach ($categories as $category){
            if($category->parent_id == 0){
                $list['parent:'] = array($category->id => $category->title);
            }
            else{
                $list[$category->where('id',$category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }
        //dd($list);


        $this->template = config('settings.theme').'.Admin.Article.edit';
        $content = view(config('settings.theme').'.Admin.Article.edit_form_content')->with(['article_edit'=> $article, 'cat_list'=>$list])->render();
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
    public function update(ArticlesRequest $request, Article $article)
    {
        //dd($request);
      $result = $this->a_rep->updateArticle($request, $article);
        if(is_array($result) && !empty($result['error'])){
            return back()->with($result);
        }
        //dd($result);

        return redirect('/admin')->with($result);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if(Gate::denies('delete', $article)){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);
            return view(config('settings.theme').'.403')->with($this->vars);
        }
        $delete = $this->a_rep->deleteArticle($article);
        //dd($delete);
        if($delete){
            return back()->with('status', 'Статья удалена!');
        }



    }
}
