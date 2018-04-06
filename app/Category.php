<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //в одный категорыъъ може бути багато записыв
    public function articles(){
        return $this->hasMany('Corp\Article');
    }
}
