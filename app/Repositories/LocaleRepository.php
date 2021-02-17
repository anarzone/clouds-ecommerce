<?php


namespace App\Repositories;


use App\Models\Locale;

class LocaleRepository extends BaseRepository
{
    public function __construct(Locale $model)
    {
        parent::__construct($model);
    }

}
