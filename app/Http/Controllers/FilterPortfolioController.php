<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Corp\Portfolio;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfoliosReppository;
use Illuminate\Http\Request;

class FilterPortfolioController extends SiteController
{
    //
    public function __construct(PortfoliosReppository $p_rep)
    {
        parent::__construct(new MenusRepository(new Menu()));
        $this->p_rep = $p_rep;
        $this->template = config('settings.theme').'.filter_portfolio';

    }

    //portfolios/filter/name
    public function index($filter = FALSE){

        $filter = $this->filterPortfolio($filter);

        $portfolio = view(config('settings.theme').'.filter_portfolio_content')->with('filter_portf', $filter)->render();
        $this->vars = array_add($this->vars, 'content', $portfolio);
        return $this->renderOutput();


    }
    //filterPortfolio
    public function filterPortfolio($filter=FALSE){
        if($filter){
            $portfolio = $this->p_rep->filter($filter, TRUE);
        }
          return $portfolio;

    }



}
