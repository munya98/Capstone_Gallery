<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Album;
class AlbumPolicy
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
    public function purge(User $user, Album $album){
        return $user->id === $album->user_id;
    }
    public function update(User $user, Album $album){
        return $user->id === $album->user_id;
    }
}
