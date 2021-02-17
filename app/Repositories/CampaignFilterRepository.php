<?php


namespace App\Repositories;

use App\Models\Campaigns\CampaignFilter;

class CampaignFilterRepository extends BaseRepository
{
    public function __construct(CampaignFilter $model)
    {
        parent::__construct($model);
    }

    public function saveFilter($campaign_id, $data){
        return $this->model->updateOrCreate(['campaign_id' => $campaign_id], $data);
    }

    public function getByCampaignId($campaign_id){
        return $this->model->where('campaign_id', $campaign_id)->first();
    }
}
