<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'team_id',
        'post_id',
        'meet_key',
        'meet_date'
    ];

    protected $dates = ['meet_date'];

    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
}
