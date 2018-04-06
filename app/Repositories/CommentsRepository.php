<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 26.02.2018
 * Time: 21:48
 */

namespace Corp\Repositories;


use Corp\Comment;

class CommentsRepository extends Repository
{
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

}