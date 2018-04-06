<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Portfolio;
use Corp\Repositories\PortfoliosReppository;
use Corp\Http\Requests\PortfolioRequest;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
class PortfolioController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PortfoliosReppository $p_rep)
    {
        parent::__construct();
        $this->p_rep = $p_rep;
        $this->template = config('settings.theme').'.Admin.Portfolio.portfolios';
    }

    public function index()
    {

        $this->title = "Менеджер Портфолио";
        $portfolios = $this->p_rep->get('*',FALSE, FALSE, FALSE);
        $content_portf = view(config('settings.theme').'.Admin.Portfolio.all_portf_content')->with('portfolios',$portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content_portf);

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //перевірка чи має користувач можливість додавати портфоліо
        if(Gate::denies('save', new \Corp\Portfolio)){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);

            return view(config('settings.theme') . '.403')->with($this->vars);
        }
        $this->title = 'Менеджер Портфолио';

        $unique_filter = $this->getFilter()->unique(function ($item) {
            return  $item->filter_alias;

        });



        $select = $unique_filter->reduce(function ($arr,$item) {
            $arr[$item->filter_id] = $item->filter_alias;
           return $arr;
        });
        //dd($select);
        $content = view(config('settings.theme').'.Admin.Portfolio.form_content')->with('select', $select)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    public function getFilter()
    {
       return $this->p_rep->get(['id','filter_id','filter_alias'], FALSE, FALSE, FALSE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
        $result = $this->p_rep->addPortfolio($request);
        if(!empty($result['error']) && is_array($result)){
            return back()->with($result)->withInput();
        }

        return redirect('admin')->with($result);

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
    public function edit(Portfolio $portfolio)
    {
        if(Gate::denies('Edit_Portfolio')){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);

            return view(config('settings.theme') . '.403')->with($this->vars);
        }
        $this->title = 'Страница редактирования портфолио '.$portfolio->title;
        $unique_filter = $this->getFilter()->unique(function ($item) {
            return  $item->filter_id;

        });

        $select = $unique_filter->reduce(function ($arr,$item) {
            $arr[$item->id] = $item->filter_alias;
            return $arr;
        });

        if($portfolio){
            $portfolio->img = json_decode($portfolio->img);
        }
        //dd($portfolio);

        $content = view(config('settings.theme').'.Admin.Portfolio.form_content')->with(['portfolio'=> $portfolio,'select'=> $select])->render();
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
    public function update(PortfolioRequest $request,Portfolio $portfolio)
    {
        $result = $this->p_rep->updatePortfolio($request, $portfolio);
        if(!empty($result['error']) && is_array($result)){
            return back()->with($result)->withInput();
        }

        return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        if(Gate::denies('Delete_Portfolio')){
            $menu = $this->getMenu();
            $navigation = view(config('settings.theme') . '.Admin.navigation')->with('menu', $menu)->render();
            $this->vars = array_add($this->vars, 'navigation', $navigation);

            return view(config('settings.theme') . '.403')->with($this->vars);
        }
        $delete = $this->p_rep->deletePortfolio($portfolio);
        if($delete){
            return redirect('admin')->with('status','Портфолио удалено!');
        }

    }
}
