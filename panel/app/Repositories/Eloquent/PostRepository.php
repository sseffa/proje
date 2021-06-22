<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * PostRepository constructor.
     *
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getPosts($team_id)
    {
        return $this->model
            ->with(['meeting', 'comment'])
            ->where('team_id', $team_id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }
}
