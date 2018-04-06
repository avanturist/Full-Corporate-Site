<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text', 'name', 'email', 'site', 'parent_id', 'user_id', 'article_id'];


    //comment звязаний з юзером
    public function user(){
        return $this->belongsTo('Corp\User');
    }
    public function article(){
        return $this->belongsTo('Corp\Article');
    }
}
