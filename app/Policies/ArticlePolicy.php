<?php

namespace Corp\Policies;

use Corp\Article;
use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
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
        return $user->authorize('Add_Articles');
    }
    public function edit(User $user){
        return $user->authorize('Update_Articles');
    }
    public function delete(User $user, Article $article){
        //хто добавив статтю той і видаляє її при умові що у нього є дозвіл на видаллення
        return ($user->authorize('Delete_Articles') && $user->id == $article->user_id);
    }
}
