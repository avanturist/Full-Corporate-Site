<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 23.02.2018
 * Time: 17:40
 */

namespace Corp\Repositories;

use Corp\Portfolio;
use Corp\Filter;
use Illuminate\Support\Facades\Gate;
use Image;

class PortfoliosReppository extends Repository
{
    public function __construct(Portfolio $portfolio)
    {
        $this->model = $portfolio;
    }

    public function addPortfolio($request){
        //окремо провірка на додавання нового портфоліо
        if(Gate::denies('save', $this->model)){
            abort(403);
        }
       $data = $request->except('_token');
        //dd($data);
        if(empty($data['alias'])){
            $data['alias'] = $this->translit($data['title']);
        }
       //преірка чи в базі існує даний alias
        $alias_exist = $this->one($data['alias']);
        ///dd($alias_exist);
        if(!is_null($alias_exist) && $alias_exist->alias === $data['alias']){
            $request->flash();
            return ['error'=>'Псевдоним '.$data['alias']. ' существует'];
        }

        if($request->hasFile('img')){
            $file = $request->img;
            $path = public_path().'/'.config('settings.theme').'/images/projects/';

            //img
            if($file->isValid()){

                $name_img = str_random(5);
                //new class
                $obj = new \stdClass();
                $obj->mini = $name_img.'_mini.jpg';
                $obj->max = $name_img.'_max.jpg';
                $obj->path = $name_img.'_path.jpg';

                $img = Image::make($file);
                $img->fit(\Config::get('settings.image_for_server')['width'], \Config::get('settings.image_for_server')['height'] )->save($path.$obj->path);
                $img->fit(\Config::get('settings.size_portfolio_img')['mini']['width'], \Config::get('settings.size_portfolio_img')['mini']['height'])->save($path.$obj->mini);
                $img->fit(\Config::get('settings.size_portfolio_img')['max']['width'], \Config::get('settings.size_portfolio_img')['max']['height'])->save($path.$obj->max);

                $data['img'] = json_encode($obj);

                }

            }


        $f = Filter::find($data['filter_id']);
        //ячейка - filter_alias
        $data['filter_alias'] = strtolower($f->title);

        $this->model->fill($data);
        //dd($f->portfolios()->save($this->model));
        if($f->portfolios()->save($this->model)){
            return ['status' => 'Портфолио добавлен!'];

        }

        return $data;
    }

    public function updatePortfolio($request, $portfolio){

    }

    public function deletePortfolio($portfolio){
        if(Gate::denies('delete', $this->model)){
            abort(403);
        }
        if($portfolio){
           return $portfolio->delete();
        }
    }
}