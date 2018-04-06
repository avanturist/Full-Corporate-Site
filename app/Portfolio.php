<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;


class Portfolio extends Model
{
    protected $table = 'portfolios';
    protected $primaryKey = 'id';

    protected $fillable = ['title','text','alias','img','customer', 'filter_alias', 'filter_id'];

    public $incrementing = TRUE;
    public $timestamps = TRUE;



    //реалізовуємо звязок One to Many табличка portfolios ->табличка filters
    public function filters(){
        return $this->belongsTo('Corp\Filter');
    }
}
