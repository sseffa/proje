<?php

namespace App\Repositories\Eloquent;

use App\Models\Meeting;
use App\Models\Team;
use App\Repositories\MeetingRepositoryInterface;

class MeetingRepository extends BaseRepository implements MeetingRepositoryInterface
{
    /**
     * MeetingRepository constructor.
     *
     * @param Meeting $model
     */
    public function __construct(Meeting $model)
    {
        parent::__construct($model);
    }

    public function getMeetings()
    {
        $teamRepository = new TeamRepository(new Team());
        $teams = $teamRepository->getTeamsByUserId(auth()->id());

        $ids = $teams->map(function($team){
            return $team['id'];
        });

        return $this->model
            ->with(['team'])
            ->whereIn('team_id', $ids->toArray())
            ->orderBy('created_at', 'ASC')
            ->get();
    }
}
