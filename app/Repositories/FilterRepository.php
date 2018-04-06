<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 06.03.2018
 * Time: 15:55
 */

namespace Corp\Repositories;


use Corp\Filter;

class FilterRepository extends Repository
{
    public function __construct(Filter $filter)
    {
        $this->model = $filter;
    }

}