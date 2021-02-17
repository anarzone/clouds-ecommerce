<?php


namespace App\Repositories;


use App\Models\Categories\GenderType;

class GenderTypeRepository extends BaseRepository
{
    public function __construct(GenderType $model)
    {
        parent::__construct($model);
    }

    public function withTranslation(){
        return $this->model->with('translation')->get();
    }
}
