<?php

namespace App\Http\Controllers;

use App\Repositories\ReplyRepositoryInterface;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    protected $replyRepository;

    public function __construct(ReplyRepositoryInterface $replyRepository)
    {
        $this->replyRepository = $replyRepository;
    }

    public function create(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);

        $this->replyRepository->create($request->all());

        return redirect()
            ->route('activities.show', ['team' => $request->get('team_id')])
            ->with('success', 'Yorumunuz başarıyla kaydedildi.');
    }
}
