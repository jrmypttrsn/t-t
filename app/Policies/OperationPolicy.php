<?php

namespace App\Policies;

use App\Models\Operation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperationPolicy
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
     * @param User $user
     * @param Operation $task
     * @return bool
     */
    public function complete(User $user, Operation $task)
    {
        return $user->is($task->user);
    }
}
