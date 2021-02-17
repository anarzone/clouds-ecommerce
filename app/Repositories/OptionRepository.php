<?php


namespace App\Repositories;


use App\Models\Products\Option;
use App\Repositories\Contractors\OptionRepositoryInterface;


class OptionRepository extends BaseRepository implements OptionRepositoryInterface
{
    public function __construct(Option $model)
    {
        parent::__construct($model);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function saveValues($id, $data)
    {
        return $this->model->values()->updateOrCreate($id, $data);
    }
}
