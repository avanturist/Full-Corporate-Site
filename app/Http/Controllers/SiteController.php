<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenusRepository;
use Corp\Repositories\SlidersRepository;
use Illuminate\Http\Request;
use Config;
use Menu;

class SiteController extends Controller
{
    //визначаємо властивості

    //властивість обекта портфоліо (rep->repository)
    protected $p_rep;

    //властивість обекта slider
    protected $s_rep;

    //властивість обекта articles
    protected $a_rep;

    //властивість обекта menu
    protected $m_rep;

    //comment
    protected $c_rep;
    //contacts
    protected $cont_rep;

    //filter
    protected $f_rep;



    //імя шаблона
    protected $template;

    //масив параметрів для передачі із шаблоном
    protected $vars = array();

    //властивості для зберігання contenty sidebara
    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;

    //будемо зберігати значення яке буде показувати що sidebar існує. По умолчанию -  sidebara не існує
    protected $bar = 'no';

    //настойки сайту title-meta
    protected $keywords;
    protected $meta_desc;
    protected $title;
    protected $author = 'Ohnitskiy';

    protected $text_contact_header = FALSE;


    public function __construct(MenusRepository $m_rep)
    {
         //доступ до обекта репозіторію меню
        $this->m_rep = $m_rep;

    }

    protected function renderOutput(){
        $menu = $this->getMenu();
        //dump($menu->all());
        $this->title = 'Престижные полы';
        //вид меню
        $navigation = view(config('settings.theme').'.navigation' )->with('menu',$menu)->render();

        //масив параметрів
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        //---------------------------------RIGHTBAR INDEX -------------------------
        //якщо contentRightBar TRUE (тобто не пустий)
        if($this->contentRightBar){
            $rightBar = view(config('settings.theme').'.contentrightBar')->with('content_right_bar', $this->contentRightBar)->render();
            $this->vars = array_add( $this->vars, 'rightBar', $rightBar);
        }
    //  -------------------------------------------------------------------/RIGHTBAR INDEX --------------------------
        //---------------------------------LEFTBAR INDEX -------------------------
        if($this->contentLeftBar){
            $leftBar = view(config('settings.theme').'.Contacts.content_L_B')->with('content_left_bar', $this->contentLeftBar)->render() ;
            $this->vars = array_add($this->vars, 'leftBar', $leftBar);
        }

        //---------------------------------/LEFTBAR INDEX -------------------------

        // ------------------------------------------------------------- BAR--------
        $this->vars = array_add($this->vars, 'bar', $this->bar);
        //dd($this->vars); //- 'right'
        // ------------------------------------------------------------/BAR----------

        // ------------------------------------------------------------FOOTER---------------------
        $footer = view(config('settings.theme').'./footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);
        //-----------------------------------------------------------/FOTER-----------------------------

        //передажмо у масив змінних закриті властивості keywords,meta_desc,title
        $this->vars = array_add($this->vars, 'keywords', $this->keywords);
        $this->vars = array_add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = array_add($this->vars, 'title', $this->title);
        $this->vars = array_add($this->vars, 'author', $this->author);

        //text_contact_header
        if($this->text_contact_header){
            $this->vars = array_add($this->vars,'text_contact_header', $this->text_contact_header );
        }
        //види
        return view($this->template)->with($this->vars);
    }

    public function getMenu(){
        $menu = $this->m_rep->get();
        //формуємо main manu
        $myMenu = Menu::make('MyNav', function ($m) use ($menu) {
           foreach ($menu as $item) {
               //dd($item);
          //перевірка рівня меню
              if($item->parent == 0){
                    //Це головне меню батькувське
                    $m->add($item->title, $item->path)->id($item->id);//назначає ідентифі батьківського пункта меню
               }
               else {
                       //відшукає батьківські пункти меню. тобто меню має підменю
                       if ($m->find($item->parent)) {
                           //якщо батьківський то добавляємо до нього дочірнє меню
                           $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                       }
               }
           }
        });

       //dump($myMenu);

        return $myMenu;
    }


    public function getSliders(){

        $sliders = $this->s_rep->get();
        if($sliders->isEmpty()){
            return FALSE;
        }
        $sliders->transform(function ($item, $key) {
            // в $key попадає шндекс коллеції а в змінну $item сама коллекція
            $item->img = Config::get('settings.slider_puth').'/'.$item->img;
            //в config->settings прописали директорію де зберігаються фото
            return $item;
        });
        //dump($sliders);
        return $sliders;
    }
}
