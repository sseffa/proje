<?php

namespace App\Http\View\Composers;

use App\Repositories\Eloquent\TeamRepository;
use Illuminate\View\View;

class TeamsComposer
{
    protected $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('teams', $this->teamRepository->getTeamsByUserId(auth()->id()));
    }
}
