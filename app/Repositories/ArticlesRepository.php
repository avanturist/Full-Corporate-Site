<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 24.02.2018
 * Time: 18:25
 */

namespace Corp\Repositories;


use Corp\Article;

use Illuminate\Support\Facades\Gate;
use Image;

class ArticlesRepository extends Repository
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function addArticle($request){
        //повторна перевірка чи має користувач права на збереження даних
        if(Gate::denies('save', $this->model)){
            abort(403);
        }
        $data = $request->except('_token', 'img');

        //якщо користувач не прописав alias ми повинні зненерувати та повернути значення alias-unique
        //транслітерація заголовка матеріала
        if(empty($data['alias'])){
            $data['alias'] = $this->translit($data['name']);

        }
        //перевірка чи в базі немає the same alias
        if($this->one($data['alias'])){
            //якщо поле порожнє то виводимо в поле alias значенн
            $request->merge(array('alias'=> $data['alias']));
            $request->flash();
            //dd($request);
            return  ['error' =>'Псевдоним уже существует!'];
        }
        //img
        //dd($request);
        if($request->hasFile('img')){
            $file = $request->img;
            $path = public_path().'/'.config('settings.theme').'/images/articles/';
            if($file->isValid()){
                //використ випадково згенеровану стрічку для імені картинок (mini, max, path)
                $str = str_random(5);
                //створ обект в якому будемо зберігати  імена картинок
                $obj = new \stdClass();
                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'_path.jpg';
                /*dd($obj);*/
               $img =  Image::make($file);
               //img for name-path
               $img->fit(\Config::get('settings.image_for_server')['width'], \Config::get('settings.image_for_server')['height'])->save($path.$obj->path);
               //img for name-mini
                $img->fit(\Config::get('settings.size_articles_img')['mini']['width'], \Config::get('settings.size_articles_img')['mini']['height'])->save($path.$obj->mini);
                $img->fit(\Config::get('settings.size_articles_img')['max']['width'], \Config::get('settings.size_articles_img')['max']['height'])->save($path.$obj->max);

                //формуємо img-json
                $data['img'] =json_encode($obj);
                //dd($data);

                $this->model->fill($data);
                //----SAVE model ---- (user поверне аутентифікованого користувача . articles()-звязок між user and articles)

               if($request->user()->articles()->save($this->model)){
                        return ['status'=>'Материал добавлен'];
                }
            }

        }
       return $data;
    }

    public function updateArticle($request, $article){
        if(Gate::denies('edit', $this->model)){
            abort(403);
        }
        $data = $request->except('_token', '_method','img');
        //транслітерація заголовка матеріала
        if(empty($data['alias'])){
            $data['alias'] = $this->translit($data['name']);

        }
        //знову перевірка alias чи не співпадає з існуючим
        $res = $this->one($data['alias']);
        //якщо id статті з псевдонімом alias що обновляємо != id статті(тобто перевірка з ішими статтями крім тіїє що обновлюється)
        //dd($res->id);//id статті 10
        //dd($res);
        if(isset($res->id) && $res->id != $article->id){
            $request->merge(array('alias', $data['alias']));
            $request->flash();
            return ['error' => 'Псевдоним уже существует!'];
        }

        //img
       if($request->hasFile('img')){

            $file = $request->img;
            $path = public_path().'/'.config('settings.theme').'/images/articles/';
            if($file->isValid()){
                //кодуємо в json
                $str = str_random(4);
                $obj = new \stdClass();
                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'__path.jpg';
                //resisum image
                $img = Image::make($file);
                //path_img
                $img->fit(\Config::get('settings.image_for_server')['width'], \Config::get('settings.image_for_server')['height'])->save($path.$obj->path);
                //mini_img
                $img->fit(\Config::get('settings.size_articles_img')['mini']['width'], \Config::get('settings.size_articles_img')['mini']['height'] )->save($path.$obj->mini);
                //max_img
                $img->fit(\Config::get('settings.size_articles_img')['max']['width'], \Config::get('settings.size_articles_img')['max']['height'])->save($path.$obj->max);

                $data['img'] = json_encode($obj);
            }
        }
        //якщо незагружаємо картинку то колонку img  не потрібно перезаписувати
        $article->fill($data);
        if($article->update()){
            return ['status' => 'Статья Обновлена!'];
        }

    }

    public function deleteArticle($article){
            if(Gate::denies('delete', $article)){
                abort('403');
            }
            //видяляэмо коменти даної статті
        $article->comments()->delete();
           if($article){
                return $article->delete();
            }

    }

    //жадна загрузка

    /*public function one($alias, $comments = array()){
        $article = parent::one($alias, $comments);
        // якщо у статті є коменти
        if($article && !empty($comments)){
            //модель comments
            $article->load('comments');//підгружаємо коментіріії
            //модель user
            $article->comments->load('user');//до підргужаних коментиарів підгружаємо ЗАРЕЄСТРОВАНОГО юзера що добавив ці коментарі.ЯКЩО не ЗАРЕЄСТРОВАНИЙ ЮЗЕР то юзер не підружається
        }

        return $article;

    }*/

}