<?php

namespace App\Http\Controllers;

use App\Repositories\TeamRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    protected $userRepository;
    protected $teamRepository;

    public function __construct(UserRepositoryInterface $userRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
    }

    public function profile()
    {
        $user = $this->userRepository->find(auth()->id());

        return view('account.profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $this->userRepository->update(auth()->id(), $request->all());

        return redirect()->route('account.profile')
            ->with('success', 'Bilgileriniz başarıyla güncellendi.');
    }

    public function teams()
    {
        $teams = $this->teamRepository->getTeamsByUserId(auth()->id());

        return view('account.teams', [
            'teams' => $teams
        ]);
    }

    public function security(Request $request)
    {
        $user = $this->userRepository->find(auth()->id());
        return view('account.security', [
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = $this->userRepository->find(auth()->id());
        $hashedPassword = $user->password;

        if (Hash::check($request->current_password, $hashedPassword)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('account.security')
                ->with('success', 'Parolanız başarıyla güncellendi.');

        }
        return redirect()->route('account.security')
            ->with('error', 'Hata oluştu.');
    }
}
