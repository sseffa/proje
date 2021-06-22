<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create new entity
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Find entity by id
     *
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Get list of all entity
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    public function update($id, array $attributes): bool
    {
        $entity = $this->model->find($id);

        $entity->username = $attributes['username'];
        $entity->email = $attributes['email'];
        $entity->first_name = $attributes['first_name'];
        $entity->last_name = $attributes['last_name'];

        return $entity->save();
    }

    /**
     * Delete entity
     *
     * @return bool
     */
    public function delete(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param array $attributes
     * @return Collection
     */
    public function select(array $attributes): Collection
    {
        return $this->model->select($attributes)->all();
    }
}
