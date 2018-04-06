<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 16.03.2018
 * Time: 13:21
 */

namespace Corp\Repositories;


use Corp\Category;

class CategoryRepository extends Repository
{
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

}