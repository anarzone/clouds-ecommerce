<?php


namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends BaseRepository
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    public function rewardRate(){
        $setting = $this->model->where('key', config('settings.rewards.rate'))->first();
        return $setting ? intval($setting->value) : 1;
    }
}
