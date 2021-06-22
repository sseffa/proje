<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_id',
        'type'
    ];

    public function meeting()
    {
        return $this->hasOne(Meeting::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->orderBy('created_at', 'DESC')
            ->limit(10);
    }
}
