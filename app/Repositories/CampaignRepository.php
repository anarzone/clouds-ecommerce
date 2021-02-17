<?php


namespace App\Repositories;


use App\Models\Campaigns\Campaign;
use App\Models\Images\Image;
use App\Models\Locale;
use App\Models\Products\ProductImage;
use App\Repositories\Contractors\CampaignRepositoryInterface;


class CampaignRepository extends BaseRepository implements CampaignRepositoryInterface
{
    public function __construct(Campaign $model)
    {
        parent::__construct($model);
    }

    public function saveTranslations($conditions, $data){
        return $this->find($conditions['campaign_id'])->translations()->updateOrCreate($conditions, $data);
    }

    public function syncProducts($campaign_id, $ids){
        return $this->find($campaign_id)->products()->sync($ids, true);
    }

    public function delete($id){
        return $this->find($id)->delete();
    }

    public function activeCampaigns(){
        return $this->model->where('status', Campaign::PUBLISHED_STATUS)->get();
    }

    public function getCampaignProducts($id){
        $campaign = $this->find($id);
        if($campaign){
            return $campaign->selectRaw('campaigns.id as campaign_id,
                        p.id,
                        p.price,
                        p.sale_price,
                        pt.title as name,
                        img.path as image
                ')
                ->where('campaigns.id', $id)
                ->leftJoin('campaign_products as cp', 'cp.campaign_id', '=', 'campaigns.id')
                ->leftJoin('products as p', 'p.id', '=', 'cp.product_id')
                ->leftJoin('product_translations as pt', 'p.id', '=', 'pt.product_id')
                ->leftJoin('product_images as pi', 'pi.product_id', '=', 'p.id')
                ->leftJoin('images as img', 'pi.image_id', '=', 'img.id')
                ->where('pi.type', ProductImage::MAIN_TYPE)
                ->where('pt.locale_id', Locale::langCode()->first()->id)
                ->whereIn('pi.image_id', function ($q){
                    $q->select('images.id')->from('images')->where('type', Image::PRODUCT_TYPE);
                })->get();
        }else{
            return [];
        }
    }
}
