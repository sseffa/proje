<?php

namespace App\Http\View\Composers;

use App\Repositories\Eloquent\TeamRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\View\View;

class JoinedTeamsComposer
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('joinedTeams', $this->userRepository->getTeams(auth()->id()));
    }
}
