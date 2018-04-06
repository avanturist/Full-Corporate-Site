<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 21.02.2018
 * Time: 21:57
 */

namespace Corp\Repositories;


use Corp\Slider;

class SlidersRepository extends Repository
{
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }
}