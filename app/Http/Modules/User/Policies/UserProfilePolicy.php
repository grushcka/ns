<?php

namespace NS\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use NS\User\Models\User;

class UserProfilePolicy
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

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User  $user
     * @param  User  $changed
     * @return Response
     */
    public function change(User $user, User $changed): Response
    {
        return $user->id === $changed->id ?
            Response::allow()
            : Response::deny('You do not own this post.');
    }


}
