<?php


namespace App\Repositories;

use App\Models\Rewards\Reward;


class RewardRepository extends BaseRepository
{
    public function __construct(Reward $model)
    {
        parent::__construct($model);
    }

    public function saveLogs($reward_id, $data){
        return $this->find($reward_id)->logs()->create($data);
    }
}
