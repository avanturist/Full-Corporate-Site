<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;
use Corp\Role;
class Permission extends Model
{
    protected $table = 'permissions';



    public function roles(){
        return $this->belongsToMany('Corp\Role');
    }
}
