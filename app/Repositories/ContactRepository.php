<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 08.03.2018
 * Time: 15:22
 */

namespace Corp\Repositories;


use Corp\Contact;

class ContactRepository extends Repository
{
    public function __construct(Contact $contact)
    {
        $this->model = $contact;
    }

}