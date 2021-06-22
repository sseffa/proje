<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    protected $postRepository;
    protected $teamRepository;

    public function __construct(PostRepositoryInterface $postRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->postRepository = $postRepository;
        $this->teamRepository = $teamRepository;
    }

    public function show($team_id)
    {
        $posts = $this->postRepository->getPosts($team_id);
        $team = $this->teamRepository->find($team_id);

        return view('activities.show', [
            'team' => $team,
            'posts' => $posts,
            'team_id' => $team_id
        ]);
    }
}
