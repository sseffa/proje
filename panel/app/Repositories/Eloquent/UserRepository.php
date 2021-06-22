<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAllUsers()
    {
        return $this->model
            ->where('id', '!=', auth()->id())
            ->where('type', 'user')
            ->select(['id', 'email', 'first_name', 'last_name'])
            ->get();
    }

    public function getTeams($user_id)
    {
        $user = $this->model
            ->where('id', $user_id)
            ->first();

        return $user->teams;
    }
}
