<?php


namespace App\Repositories;


use App\Models\Categories\AgeType;

class AgeTypeRepository extends BaseRepository
{
    public function __construct(AgeType $model)
    {
        parent::__construct($model);
    }

    public function withTranslation(){
        return $this->model->with('translation')->get();
    }
}
