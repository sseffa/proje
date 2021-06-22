<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/teams/create', [TeamsController::class, 'create'])->name('teams.create');

    Route::get('/teams/store', [TeamsController::class, 'store'])->name('teams.store');

    Route::get('/users', [UsersController::class, 'index'])->name('users.index');

    Route::get('/activities/{team}', [ActivitiesController::class, 'show'])->name('activities.show');

    Route::get('/team/members/{team}', [MembersController::class, 'show'])->name('members.show');

    Route::get('/about', [PagesController::class, 'about'])->name('about');

    Route::get('/getAllUsers',  [UsersController::class, 'getAllUsers'])->name('get.all.users');


    Route::post('/teams/addMember',  [TeamsController::class, 'addMember'])->name('add.member');
    Route::post('/teams/removeMember',  [TeamsController::class, 'removeMember'])->name('remove.member');
    Route::post('/teams/joinTeam',  [TeamsController::class, 'joinTeam'])->name('join.team');


    Route::post('/create-comment',  [CommentController::class, 'create'])->name('create.comment');
    Route::post('/create-meeting',  [MeetingController::class, 'create'])->name('create.meeting');

    Route::get('/meet/{key}',  [MeetingController::class, 'meet'])->name('meet');

    Route::get('/account/profile',  [AccountController::class, 'profile'])->name('account.profile');
    Route::get('/account/update',  [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/teams',  [AccountController::class, 'teams'])->name('account.teams');

    Route::any('/account/security',  [AccountController::class, 'security'])->name('account.security');
    Route::any('/account/update-password',  [AccountController::class, 'updatePassword'])->name('account.security.save');


    Route::get('/getMeetings',  [MeetingController::class, 'getMeetings'])->name('get.meetings');

    Route::post('/addReply',  [RepliesController::class, 'create'])->name('add.reply');


});



require __DIR__.'/auth.php';
