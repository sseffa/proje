<?php

namespace App\Repositories\Eloquent;

use App\Models\Team;
use App\Models\User;
use App\Repositories\TeamRepositoryInterface;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{

    /**
     * TeamRepository constructor.
     *
     * @param Team $model
     */
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function getTeamsByUserId($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->get();
    }

    public function getTeams($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->get();
    }

    public function getMembers($team_id){

        return $this->model->with('users')->where('id', $team_id)->first()->users;
    }

    public function attachUserToTeam($team_id, $user_id)
    {
        $team = $this->find($team_id);
        $user = User::find($user_id);

        //$team->users()->attach($user);

        $team->users()->syncWithoutDetaching([$user->id]);

        return true;
    }

    public function deattachUserToTeam($team_id, $user_id)
    {
        $team = $this->find($team_id);
        $user = User::find($user_id);

        $team->users()->detach($user);

        return true;
    }

    public function joinToTeam($code, $user_id)
    {
        $team = $this->model->where('code', $code)->first();
        if (empty($team)) throw new \Exception('Girdiğiniz kod geçersiz.');

        if ($team->is_public === 0) throw new \Exception('Girdiğiniz koda sahip ekip, herkese açık değil.');

        $user = User::find($user_id);

        //$team->users()->attach($user);

        $team->users()->syncWithoutDetaching([$user->id]);

        return true;
    }
}
