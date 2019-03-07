<?php

namespace App\Policies;

use App\User;
use Illumiate\Auth\Access\HandlesAuthorization;
use App\Streamer;

class StreamerPolicy
{

    /**
     * Assert that a user owns a streamer.
     *
     * @return boolean
     */
    public function owns(User $user, Streamer $streamer)
    {
        return (int) $streamer->user_id === $user->id;
    }
}
