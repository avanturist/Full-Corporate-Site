<?php

namespace Corp\Http\Controllers;

use Corp\Article;
use Corp\Category;
use Corp\Menu;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\CommentsRepository;
use Corp\Repositories\MenusRepository;

use Corp\Repositories\PortfoliosReppository;
use Illuminate\Http\Request;
use Config;
class ArticlesController extends SiteController
{
    public function __construct(ArticlesRepository $a_rep, PortfoliosReppository $p_rep, CommentsRepository $c_rep)
    {
        parent::__construct(new MenusRepository(new Menu()));
        //визначаємо властивості та шаблон
        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;
        $this->c_rep = $c_rep;
        $this->bar = 'right';
        $this->template = config('settings.theme') . '.articles';
    }

    //index для відображення template->blog
    public function index($cat_alias = FALSE)
    {
        // - ------- Article(викладаємо портфоліл in right Bar) Right Bar -----------------------------------
        $articleSideBar = $this->ArticleRightBar();
        //dd($articleSideBar);
        $comments = $this->ArticleCommentsBar(Config::get('settings.latest_comm_articl_bar'));
        //dd($comments);
        $this->contentRightBar = view(config('settings.theme') . '.articleContentBar')->with(['articleBarPor' => $articleSideBar, 'comments' => $comments])->render();

        //------------ /Article Right Bar -------------------------------

        //
        //dd($cat_alias);
        $articles = $this->getArticles($cat_alias);
        //dd($articles->reverse());
        $content = view(config('settings.theme') . '.articles_content')->with(['art_content'=> $articles, 'comments' => $comments])->render();
        $this->vars = array_add($this->vars, 'content', $content);

        //
        return $this->renderOutput();

    }

    public function getArticles($cat_alias = FALSE)
    {
        $where = FALSE;
        if ($cat_alias) {
            //якщо сат=true то вибираємо дані з бази з врахуванням $cat_alias
            $id = Category::where('alias', $cat_alias)->first()->id;
            //dd($id);// визначили id активної категорії
            // в репозиторій передаємо в метод get додатковий параметр $where

            $where = ['category_id', $id];
        }
        //поле id для звязку поля article_id в comments для виведення кількості коментарів
        $select = ['id','name', 'alias', 'created_at', 'img', 'desc', 'user_id', 'category_id'];
        $all_article = $this->a_rep->get($select, FALSE, TRUE, $where);

        if ($all_article) {
            $all_article->load('user', 'category', 'comments');//піддгружає конкретну інфу на початку формування обєкту all_article із звязаних моделей/ В кінцевому результ ми отримуємо меньшу кількість SQL запросів та не перегружаємо сервер
        }


        return $all_article;
    }

    //Article Right Bar
    public function ArticleRightBar()
    {
        $select = ['title', 'text', 'img', 'created_at', 'filter_alias', 'alias'];
        $latestPort = Config::get('settings.latest_portf_articl_bar');
        $rightBar = $this->p_rep->get($select, FALSE, FALSE);
        //dd($rightBar);
        return $rightBar->take($latestPort);
    }

    //ArticleCommentsBar
    function ArticleCommentsBar($amount)
    {
        $select = '*';

        $comm = $this->c_rep->get($select, FALSE, FALSE);
        if ($comm) {
            $comm->load('user', 'article');

        }
        //dd($comm);
        return $comm->take($amount);
    }

    //articles/articl
    public function show($alias = FALSE)
    {
        // --------------------------------------FIRST WAY-----------------------------------------------
     /*   $where = FALSE;
        if ($alias) {
            //id статті передаємо в репозиторій
            $id = Article::where('alias', $alias)->first()->id;
            $where = ['id', $id];
            //dd($id);

        }
        $select = ['id','name', 'text', 'alias', 'img', 'created_at', 'user_id', 'category_id'];
        $one_article = $this->a_rep->get($select, FALSE, FALSE, $where);
        //dd($one_article);
        if($one_article){
            $one_article->load('user', 'category','comments');
        }

        //також оприділили змінні правого сайд бару для відображення сторінки articles/ Template для відображення сторінки це ARTICKES(ми оприділили в constract)
        $articleSideBar = $this->ArticleRightBar();
        $comments = $this->ArticleCommentsBar(Config::get('settings.latest_comm_articl_bar'));
        $this->contentRightBar = view(config('settings.theme') . '.articleContentBar')->with(['articleBarPor' => $articleSideBar, 'comments' => $comments])->render();
        //----------------------------------------------
        //article/article-#
        $view_article = view(config('settings.theme') . '.showArticle')->with('one_artic', $one_article)->render();//шаблон сторінки яку ми передаємо в контент
        $this->vars = array_add($this->vars, 'content', $view_article);*/
        // ---------------------------------------END FIRST WAY------------------------------------------

        // --------------------------------------- SECOND WAY------------------------------------------

        //також оприділили змінні правого сайд бару для відображення сторінки articles/ Template для відображення сторінки це ARTICKES(ми оприділили в constract)
        $articleSideBar = $this->ArticleRightBar();
        $comments = $this->ArticleCommentsBar(Config::get('settings.latest_comm_articl_bar'));
        $this->contentRightBar = view(config('settings.theme') . '.articleContentBar')->with(['articleBarPor' => $articleSideBar, 'comments' => $comments])->render();
        //
        // method onе в репозиторыы верне одну запись по псевдоныму
        $one_article = $this->a_rep->one($alias);
        //dd($one_article);
        //розділяємо j-son строку
        if($one_article){
            $one_article->img = json_decode($one_article->img);
        }

        if($one_article){
            $one_article->load('user', 'category', 'comments');
        }
        //dd($one_article->comments->groupBy('parent_id'));

        //article/article-#
        $view_article = view(config('settings.theme') . '.showArticle')->with('one_artic', $one_article)->render();//шаблон сторінки яку ми передаємо в контент
        $this->vars = array_add($this->vars, 'content', $view_article);
        $this->meta_desc = $one_article->meta_desc;
        $this->title = $one_article->name;
        $this->keywords = $one_article->keywords;
        // ------------------------------------------END SECOND WAY--------------------------------------


        return $this->renderOutput();
    }


}
