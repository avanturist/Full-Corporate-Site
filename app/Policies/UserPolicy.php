<?php

namespace Corp\Policies;

use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function create(User $user){
        return $user->can('Edit_Users');
    }

    public function edit(User $user){
        return $user->can('Edit_Users');
    }

    public function delete(User $user){
        return $user->can('Delete_Users');
    }
}
