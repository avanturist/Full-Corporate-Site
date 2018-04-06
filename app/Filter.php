<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    //
    protected $table = 'filters';

    public function portfolios(){
        return $this->hasMany('Corp\Portfolio');
    }
}
