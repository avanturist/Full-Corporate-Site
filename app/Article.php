<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'text', 'desc', 'alias', 'img', 'keywords', 'meta_desc','category_id'];

    public $incrementing = TRUE;
    public $timestamps = TRUE;


    //конкретня стаття належить конкретному юзеру
    public function user(){
        return $this->belongsTo('Corp\User');
    }

    //конкректа стаття може належати конкретній категорії
    public function category(){
        return $this->belongsTo('Corp\Category');
    }
    // КОНКРЕТНа стаття звязується з багатьмя коментами
    public function comments(){
        return $this->hasMany('Corp\Comment');
    }

}
