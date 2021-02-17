<?php


namespace App\Repositories\Contractors;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param $id
     */
    public function find($id);


    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function save($id, $data);
}
