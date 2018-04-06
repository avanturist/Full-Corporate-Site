<?php

namespace Corp\Policies;

use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function save(User $user){
        return $user->can('Add_Portfolio');
    }


    public function delete(User $user){
        return $user->can('Delete_Portfolio');
    }
}
