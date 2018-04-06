<?php

namespace Corp\Http\Controllers;


use Corp\Menu;

use Corp\Repositories\ContactRepository;
use Corp\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class ContactController extends SiteController
{
    //
    public function __construct(ContactRepository $cont_rep)
    {
        parent::__construct(new MenusRepository(new Menu()));
        $this->cont_rep = $cont_rep;
        $this->bar = 'left';
        $this->template = config('settings.theme').'.Contacts.contact';
    }

    public function index(Request $request){
        //отправка EMAIL
        if($request->isMethod('post')){
            $data =  $request->only(['name','email', 'message']);
            //validation
            $rules = [
                'name' => 'required|max:20',
                'email' => 'required|email',
                'message' => 'required|string',

            ];
            $messages = [
                'required' => 'Поле не должно быть пустым! ',
                'email'    => 'Поле Email должно соответствовать email-адресу '
            ];

            $validator = Validator::make($data, $rules, $messages);

            if($validator->fails()){
                return redirect()->route('contact')->withErrors($validator)->withInput();
            }



            //відправка емаіл
            $result = Mail::send(config('settings.theme').".Email.emails_orders", ['data'=>$data], function ($message) use ($data){
                $mail_admin = env('MAIL_ADMIN');
                $message->from($data['email'], $data['name']);
                $message->to($mail_admin)->subject('Question');


            });
            //dd($result); //null
            if(is_null($result)){
                return redirect()->route('contact')->with('status','Email отправлен!');
            }

        }
        //content->leftBar
        $get_contacts = $this->getContacts();
        if($get_contacts){
            $all_contacts = $get_contacts->first();
        }
        //dd($get_contacts->first());
        $this->contentLeftBar = view(config('settings.theme').'.Contacts.leftBar')->with('contact', $all_contacts)->render();


        //content->contacts
        $contact = view(config('settings.theme').'.Contacts.content_contact')->render();
        $this->vars = array_add($this->vars, 'content', $contact);

        $this->title = 'Контакты';
        $this->text_contact_header = view(config('settings.theme').'.Contacts.text_contact_header');

        return $this->renderOutput();
    }

    public function getContacts(){
        $contacts = $this->cont_rep->get('*', FALSE,FALSE,FALSE);
        return $contacts;
    }


}
