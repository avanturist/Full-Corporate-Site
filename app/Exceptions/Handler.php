<?php

namespace Corp\Exceptions;

use Corp\Http\Controllers\SiteController;
use Corp\Menu;
use Corp\Repositories\MenusRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $name = 'login';

    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        //dd($exception);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */


    public function render($request, Exception $exception)
    {
        //доступ до меню
        $menu = new SiteController(new MenusRepository(new Menu));
        $menu = $menu->getMenu();
        //dd($menu);
        $navigation = view(config('settings.theme').'.navigation' )->with('menu',$menu)->render();

       if($this->isHttpException($exception)){
           $code = $exception->getStatusCode();
           //dd($code); //404
           switch ($code){
               case '404':
                   return response()->view(config('settings.theme').'.404', ['bar'=>'no', 'title'=>'Страница не найдена', 'navigation'=>$navigation]);

           }

        }
        //якщо пройшло багато часу від авторизації Route[login] не знайде тому повертаємо помилку
        elseif ($exception->getMessage() == 'Unauthenticated.' ){
            return response()->view(config('settings.theme').'.404', ['bar'=>'no', 'title'=>'Страница не найдена', 'navigation'=>$navigation]);
        }
        //запишимо в файл логов повідомлення що сторінки не існнує

        //---2й спосіб
   /*     if($exception instanceof NotFoundHttpException){

            Log::info('Страница не найдена - '. $request->url());

            return response()->view(config('settings.theme').'.404', ['bar'=>'no', 'title'=>'Страница не найдена', 'navigation'=>$navigation]);
        }*/



        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
