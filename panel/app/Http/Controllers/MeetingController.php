<?php

namespace App\Http\Controllers;

use App\Repositories\MeetingRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    protected $postRepository;
    protected $meetingRepository;

    public function __construct(PostRepositoryInterface $postRepository, MeetingRepositoryInterface $meetingRepository)
    {
        $this->postRepository = $postRepository;
        $this->meetingRepository = $meetingRepository;
    }

    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'meet_date' => 'required',
        ]);

        $post = $this->postRepository->create([
            'user_id' => auth()->id(),
            'team_id' => $request->get('team_id'),
            'type' => 'meeting'
        ]);

        $this->meetingRepository->create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'content' => $request->get('content'),
            'meet_key' => GUID(12),
            'meet_date' => $request->get('meet_date'),
            'team_id' => $request->get('team_id'),
        ]);

        return redirect()
            ->route('activities.show', ['team' => $request->get('team_id')])
            ->with('success', 'Toplantı başarı ile oluştuşturuldu.');
    }

    public function meet($key)
    {
        return view('meeting.meet',[
            'channel' => $key
        ]);
    }

    public function getMeetings()
    {
        $meetings = $this->meetingRepository->getMeetings();

        return response()->json($meetings);
    }
}
