<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Corp\Repositories\FilterRepository;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfoliosReppository;
use Illuminate\Http\Request;
use Config;

class PortfolioContoller extends SiteController
{
    //
    public function __construct(PortfoliosReppository $p_rep, FilterRepository $f_rep)
    {
        parent::__construct(new MenusRepository(new Menu()));

        $this->f_rep = $f_rep;
        $this->p_rep = $p_rep;
        $this->template = config('settings.theme').'.portfolio_index';
    }

    public function index(){

        //повертаємо всі портфоліо але з пагінацією на сторінці по 3шт
        $all_portf = $this->getPortfolios();

        $view_portfolio = view(config('settings.theme').'.content_portfolio')->with('all_portsf', $all_portf)->render();
        $this->vars = array_add($this->vars, 'content', $view_portfolio);

        return $this->renderOutput();
    }

    public function getPortfolios(){
        $select = ['title', 'text', 'alias', 'customer', 'created_at', 'img', 'filter_alias'];
        $amount = Config::get('settings.all_portfolio_count');
        $portfolios = $this->p_rep->get($select, FALSE, TRUE, FALSE );
        //dd($portfolios);
        return $portfolios;
    }

    public function show($alias_portf = FALSE){

        $one_portfolio = $this->p_rep->one($alias_portf);

        if($one_portfolio){
            $one_portfolio->img = json_decode($one_portfolio->img);
        }
        //dd($one_portfolio);

        //all_portfolio для відображення в контенті
        $select = ['id','img', 'title', 'alias', 'filter_alias'];
        $portfolios_one_content = $this->p_rep->get($select, FALSE, FALSE, FALSE);

        //дані з таблички filters для відображення кнопок фільтрації на сторінці /portfolios/filter
        $filter_all = $this->f_rep->get('*', FALSE, FALSE, FALSE);
          //dd($filter_all);

        //dd($portfolios_one_content);

        $view_portf = view(config('settings.theme').'.content_one_portf')->with(['one_portf'=> $one_portfolio, 'all_prt_content'=>$portfolios_one_content, 'filter_prt'=>$filter_all])->render();
        $this->vars = array_add($this->vars, 'content', $view_portf);



        return $this->renderOutput();

    }

}
