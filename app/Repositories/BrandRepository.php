<?php


namespace App\Repositories;


use App\Models\Brands\Brand;


class BrandRepository extends BaseRepository
{
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }
}
