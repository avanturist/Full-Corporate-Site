<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 21.02.2018
 * Time: 14:14
 */

namespace Corp\Repositories;
use Config;

abstract class Repository
{
    protected $model = FALSE;

    public function get($select = '*', $take = FALSE, $pagination=FALSE, $where=FALSE){
        //обект класса bilder
        $bilder = $this->model->select($select);
        // ----------------------take
        if($take) {
            //тут можемо задати параметр що буде приймати кількіть (статтей, портфоліо, коьентарів, і тд)
             $bilder =  $bilder->take($take);
        }
        //dd($bilder);

        //---------------------------where
        if($where){
            // ['category_id', $id] де [0]->category_id,  a [1]->$id
            $bilder->where($where[0], $where[1]);
        }

        //-------------------------pagination
        if($pagination){
           return $this->check($bilder->paginate(Config::get('settings.paginate')));
        }


        // формуємо метод - check
        return $this->check($bilder->get());

    }

    //оброботка строчки формату json що зберігає в базі дані ->img
    protected function check($result){
        /*dd($result);*/
        if($result->isEmpty()){
            return FALSE;
        }
        //перетворюємо строчку json в обект
        $result->transform(function ($item, $key){
            //dd($item);
            //json_decod -> преобразовує json стрічку в змінну PHP тобто{"mini":"foto.jpg"}то в $item попадає foto.jpg
            //умова чи у колоці img строка та після обробки її повертається обект та чи були допущені помилки про роботі з json строкою
            // тільки для цього формату наступна дія
            if(is_string($item->img) && is_object( json_decode($item->img)) && json_last_error() == JSON_ERROR_NONE){
                $item->img = json_decode($item->img);

            }
            //dd($item);
            return $item;

        });

        return $result;

    }

    //метод повертає одну статтю по alias
    public function one($alias){
        /*$hasOneArticle = $this->model->where('alias',$alias)->first();*/
        $hasOneArticle = $this->model->select('*')->where('alias',$alias)->first();//the same that previous

        return $hasOneArticle;
    }
    //alias for articles translate in the sting in latin
    public function translit($title){
        $translit=array(
            "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d","Е"=>"e","Ё"=>"e","Ж"=>"zh","З"=>"z","И"=>"i","Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n","О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t","У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch","Ш"=>"sh","Щ"=>"shch","Ъ"=>"","Ы"=>"y","Ь"=>"","Э"=>"e","Ю"=>"yu","Я"=>"ya",
            "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e","ж"=>"zh","з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l","м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h","ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"shch","ъ"=>"","ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
            "A"=>"a","B"=>"b","C"=>"c","D"=>"d","E"=>"e","F"=>"f","G"=>"g","H"=>"h","I"=>"i","J"=>"j","K"=>"k","L"=>"l","M"=>"m","N"=>"n","O"=>"o","P"=>"p","Q"=>"q","R"=>"r","S"=>"s","T"=>"t","U"=>"u","V"=>"v","W"=>"w","X"=>"x","Y"=>"y","Z"=>"z"
        );
        $s = strip_tags(trim($title));
        $s = mb_strtolower($s, 'UTF-8');
        $s = str_replace(" ", '-', $s);

        $s = str_replace(array('\n', '\r'), '', $s);
        //якщо в titli є цифри та символи \s пробіл ^-невходить
       /* foreach ($translit as $latin => $kyr){
            $res = preg_replace('/(\s)+/','-', $res);
        }*/
        $s = preg_replace('/["?!:$%*]/','',$s);
        $res = strtr($s,$translit);
        return $res;
    }
    //filtration portfolio
    public function filter($filter = FALSE, $pagigination = FALSE){

        $portfolio = $this->model->select('*');
        //dd($portfolio);
        if($filter){
            $filtered = $portfolio->where('filter_alias', $filter);
        }

        if($pagigination){
           return $this->check($portfolio->paginate(Config::get('settings.paginate')));
        }
        //dd($filtered);
        return $this->check($filtered->get());


    }

    /*public function one($alias, $comments = array() ){
        //в такому випадку будуть вибиратися всі поля конкретної статті по псевдоніму
       $one_article =  $this->model->where('alias', $alias)->first();
        //dd($one_article);
       return $one_article;
    }*/

    //

}

