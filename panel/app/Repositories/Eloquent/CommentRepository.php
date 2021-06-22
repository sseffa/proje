<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Repositories\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * CommentRepository constructor.
     *
     * @param Comment $model
     */
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }
}
