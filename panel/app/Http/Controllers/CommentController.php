<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentRepository;
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository, CommentRepositoryInterface $commentRepository)
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    public function create(Request $request)
    {
        $post = $this->postRepository->create([
            'user_id' => auth()->id(),
            'team_id' => $request->get('team_id'),
            'type' => 'comment'
        ]);

        $this->commentRepository->create([
            'post_id' => $post->id,
            'content' => $request->get('content'),
            'user_id' => auth()->id(),
            'team_id' => $request->get('team_id'),
        ]);

        return redirect()
            ->route('activities.show', ['team' => $request->get('team_id')])
            ->with('success', 'Bilgilendirme başarı ile oluştuşturuldu.');
    }
}
