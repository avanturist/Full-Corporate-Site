<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 26.03.2018
 * Time: 15:06
 */

namespace Corp\Repositories;


use Corp\Role;

class RolesRepository extends Repository
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

}