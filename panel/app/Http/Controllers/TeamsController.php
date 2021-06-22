<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Notifications\AddedToTeam;
use App\Notifications\JoinedToTeam;
use App\Notifications\RemovalFromTeam;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    protected $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function create()
    {
        return view('teams.create', []);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);

        $team = $this->teamRepository->create($request->all());

        return redirect()->route('activities.show', ['team' => $team->id])
            ->with('success', 'Ekip başarı ile oluştuşturuldu.');
    }

    function addMember(Request $request)
    {
        $userId = $request->get('userId');
        $teamId = $request->get('teamId');

        $this->teamRepository->attachUserToTeam($teamId, $userId);

        User::find($userId)->notify(new AddedToTeam(Team::where('id', $teamId)->first()));

        return response()->json(['status' => 'success']);
    }

    function removeMember(Request $request)
    {
        $userId = $request->get('userId');
        $teamId = $request->get('teamId');

        $this->teamRepository->deattachUserToTeam($teamId, $userId);

        User::find($userId)->notify(new RemovalFromTeam(Team::where('id', $teamId)->first()));

        return response()->json(['status' => 'success']);
    }

    function joinTeam(Request $request)
    {
        $userId = $request->get('userId');
        $code = $request->get('code');

        try {
            $this->teamRepository->joinToTeam($code, $userId);

            User::find($userId)->notify(new JoinedToTeam(Team::where('code', $code)->first()));

        } catch (\Exception $exception) {
            return response()->json(['status' => 'failed', 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => 'success']);
    }
}
