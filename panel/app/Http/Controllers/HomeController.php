<?php

namespace App\Http\Controllers;

use App\Repositories\MeetingRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        return view('home.index', );
    }
}
