<?php

namespace Corp\Http\Controllers;

use Corp\Article;
use Corp\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Requests;
use Auth;
use Validator;

class CommentController extends SiteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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
        //ответ от сервера- люба строка яка відображаеться на екран.
       /* echo json_encode(['hello'=>'world']);
        exit();*/

        $data = $request->except('_token', 'comment_post_ID', 'comment_parent');

            //після отправки даних на сервер без перезазрузки ми отримаємо дані (відповідь від сервера) у консолі
            $data['article_id'] = $request->input('comment_post_ID');
            $data['parent_id'] = $request->input('comment_parent');

            //validation data

            $rules = [
                    'text'  => 'string|required',
                    'article_id' => 'integer|required',
                    'parent_id' => 'integer|required',
                    ];
            $messages = [
                        'required' => 'Поле :attribute должно быть заполнены!',
                        'integer' => 'Поле :attribute должно быть целоцисленным',
                    ];
            $validator = Validator::make($data, $rules, $messages);

            //якщо юзер незареєстрований то необхідно провірити на валідність решту полів
            $validator->sometimes(['name', 'email'], 'required|max:100', function ($input) {
                   return !Auth::check();
            });

            if($validator->fails()){
                //відповідь серверу у вигляді json стрічки (dataType - умова в ajax)
                return response()->json(['error'=>$validator->errors()->all()]);
                // в ячейку error записуємо масив з помилками
                //$validator->errors()->all()-метод all() перетворить обьект з помилками малідації на масив
            }
            //-----------------------------------------sava data into DB
            //проверка чи є аутентифікований юзер
            $user = Auth::user();


            //формуємо нову модель Comment(у властивість нової моделі записуємо наші дані)
            $comment = new Comment($data);
            //якщо юзер аутентифікований то у властивість (user_id comments) Ми присвоюємо id аутентифікованого юзера
            if($user){
                $comment->user_id = $user->id;
            }
            //зберігаємо коммент в БД
            // форм модель article щоб присвоїти для  article_id comments -> id конкретного поста
            // до конкретного поста (по article_id)  зберігаємо комент
            $articl = Article::find($data['article_id']);

            $articl->comments()->save($comment);

            //нас цікавить юзер який добавив комент. Якщо юзер футентиф то ми получемо його дані.Збираємо інфу про юзера
           $comment->load('user');

           $data['id'] = $comment->id;//id коментаря
           // умова якщо юзер зареєстрований то даних email небуде тоді нам поортібно іх витягнути із табл users
            $data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;
            //аналогічно імя юзера
            $data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->name;
            //avatarka usera
            $data['hash'] = md5($data['email']);


        //в тимчасову змінну (вид) зберігаємо наші дані/ цей вид відправимо на сервер як відповідь у вигляді html
            $view_comment = view(config('settings.theme').'.content_one_coment')->with('data', $data)->render();
        //відповідь на сервев (у метод ajax відправляємо дані у параметр  success)
            return \Response::json(['success' => true, 'comment' => $view_comment, 'data'=>$data]);

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
