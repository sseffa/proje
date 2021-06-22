<?php

namespace App\Repositories\Eloquent;

use App\Models\Reply;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\ReplyRepositoryInterface;

class ReplyRepository extends BaseRepository implements ReplyRepositoryInterface
{
    /**
     * ReplyRepository constructor.
     *
     * @param Reply $model
     */
    public function __construct(Reply $model)
    {
        parent::__construct($model);
    }
}
