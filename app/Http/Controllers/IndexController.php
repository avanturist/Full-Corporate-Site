<?php

namespace Corp\Http\Controllers;


use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\MenusRepository;
use Corp\Menu;

use Corp\Repositories\PortfoliosReppository;
use Corp\Repositories\SlidersRepository;
use Corp\Slider;
use Illuminate\Http\Request;
use Config;

class IndexController extends SiteController
{
    public function __construct(PortfoliosReppository $p_rep, ArticlesRepository $a_rep, SlidersRepository $s_rep )
    {
        parent::__construct(new MenusRepository(new Menu()));

        //визначаємо репозиторій портфоліфо
        $this->p_rep = $p_rep;
        //-------------------------------------
        //визна репозиторій articles
        $this->a_rep = $a_rep;

        //-------------------------------------
        $this->s_rep = $s_rep;

        //на головній сторінці є правий sidebar
        $this->bar = 'right';
        $this->template = config('settings.theme').'.index';// імя головного шаблону


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //slider - - - render- це отработка у вигляді строки шаблона $sliders
        $sliderItems = $this->getSliders();
        $sliders = view(config('settings.theme').'.slider')->with('sliders', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'sliders', $sliders);
        //----------PORTFOLIO------------
        //получаємо портфоліо які будуть відображатись на головній сторінці

        $portfolios = $this->getPortfolio();
        //добавляємо в масив змінних vars
        $last_p = $portfolios->last();
        //dd($last_p);
        $portf = view(config('settings.theme').'.portfolio')->with(['portf'=>$portfolios, 'last'=>$last_p])->render();
        $this->vars = array_add($this->vars, 'portfolio', $portf);

        //----------/PORTFOLIO--------------------------

        //---------RIGHTSIDEBAR-визначаємо -protected $contentRightBar----------------------
        //получаемо інфу яка буде передаватися в правий сайдбар в шаблон головної сторінки
        $indexArticle = $this->Articles_Bar_Index();
        //dd($indexArticle);
        $this->contentRightBar = view(config('settings.theme').'.indexSidebar')->with('articles',$indexArticle->reverse())->render();

        //----------/RightSideBar------------------------

        //----------------------переоприділяєо властивості
            $this->keywords = 'laminat,parket, some words for finding this site in the internet';
            $this->meta_desc = 'Description about site';
            $this->title = 'Pink Rio';

        //-----------------///////////////


       return $this->renderOutput();
    }

    //витягуємо портфоліо але тільки 5 шт останніх (в settings прописали "-5" тобто з кінця)
    protected function getPortfolio(){
        //вказуємо кількість портфоліо що ми будемо витягувати з бази
        $take = Config::get('settings.home_portfolio_count');
        $p = $this->p_rep->get();
        //dd($p);
        $latest_portfolio = $p->take($take);

        return $latest_portfolio;
    }


    //витягуємо статті що відображаються в правому сайдбарі на indexi
    public function Articles_Bar_Index(){
        $select = Config::get('settings.articles_only');
        /*$take  = Config::get('settings.home_articles_count');*/
        $articles = $this->a_rep->get($select,FALSE);
        $latest_articles = $articles->take(-3);
        return $latest_articles ;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
