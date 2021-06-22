<?php

namespace App\Http\Controllers;

use App\Repositories\TeamRepositoryInterface;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    protected $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function show($team_id)
    {
        $members = $this->teamRepository->getMembers($team_id);
        $team = $this->teamRepository->find($team_id);

        return view('members.show', [
            'members' => $members,
            'team' => $team
        ]);
    }
}
