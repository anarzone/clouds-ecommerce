<?php


namespace App\Repositories;


use App\Repositories\Contractors\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->create($attributes);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function all(): Collection{
        return $this->model->all();
    }

    public function save($id, $data)
    {
        return $this->model->updateOrCreate(['id' => $id], $data);
    }
}
