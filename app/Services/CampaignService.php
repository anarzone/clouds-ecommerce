<?php


namespace App\Services;


use App\Helpers\ActionHelper;
use App\Models\Campaigns\Campaign;
use App\Repositories\AgeTypeRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CampaignRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GenderTypeRepository;
use App\Repositories\LocaleRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\CampaignFilterRepository;

class CampaignService
{
    use ActionHelper;

    private $campaignRepository,
            $localeRepository,
            $genderTypeRepository,
            $ageTypeRepository,
            $categoryRepository,
            $brandRepository,
            $productTypeRepository,
            $productRepository,
            $campaignFilterRepository
    ;

    public function __construct(CampaignRepository $campaignRepository,
                                LocaleRepository $localeRepository,
                                GenderTypeRepository $genderTypeRepository,
                                AgeTypeRepository $ageTypeRepository,
                                CategoryRepository $categoryRepository,
                                BrandRepository $brandRepository,
                                ProductTypeRepository $productTypeRepository,
                                ProductRepository $productRepository,
                                CampaignFilterRepository $campaignFilterRepository
    )
    {
        $this->campaignRepository = $campaignRepository;
        $this->localeRepository = $localeRepository;
        $this->genderTypeRepository = $genderTypeRepository;
        $this->ageTypeRepository = $ageTypeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->productTypeRepository = $productTypeRepository;
        $this->productRepository = $productRepository;
        $this->campaignFilterRepository = $campaignFilterRepository;
    }

    public function index(){
        return [
            'campaigns' => $this->campaignRepository->all(),
        ];
    }

    public function create(){
        return [
            'locales' => $this->localeRepository->all(),
            'genderTypes' => $this->genderTypeRepository->all(),
            'ageTypes' => $this->ageTypeRepository->all(),
            'parentCategories' => $this->categoryRepository->parents(),
            'brands' => $this->brandRepository->all(),
            'productTypes' => $this->productTypeRepository->all(),
        ];
    }

    public function edit($id){
        return [
            'filter' => $this->mapCampaignFilter($this->campaignFilterRepository->getByCampaignId($id)),
            'campaignProducts' => $this->mapCampaignProducts($this->campaignRepository->find($id)->products),
            'campaign' => $this->campaignRepository->find($id),
            'locales' => $this->localeRepository->all(),
            'genderTypes' => $this->genderTypeRepository->all(),
            'ageTypes' => $this->ageTypeRepository->all(),
            'parentCategories' => $this->categoryRepository->parents(),
            'brands' => $this->brandRepository->all(),
            'productTypes' => $this->productTypeRepository->all(),
        ];
    }

    public function save($data){
        $saveData = [
            'rate' => $data->rate,
            'rate_type' => $data->rate_type,
            'campaign_type' => $data->campaign_type,
            'status' => $data->status,
        ];

        if($data->has('cover')){
            $saveData['cover'] = $this->uploadImage($data->cover, Campaign::IMAGE_PATH);
        }

        $campaign = $this->campaignRepository->save($data->campaign_id, $saveData);

        $locales = $this->localeRepository->all();

        $this->campaignRepository->syncProducts($campaign->id, $data->product_ids);

        $queryFilter = json_decode($data->filterQuery);

        $this->campaignFilterRepository->saveFilter($campaign->id, [
            'campaign_id' => $campaign->id,
            'age_type_ids' => implode(",",$queryFilter->ageTypes),
            'gender_type_ids' => implode(",", $queryFilter->genderTypes),
            'category_ids' => implode(",", $queryFilter->categories),
            'brand_id' => $queryFilter->brandId,
            'product_type_id' => $queryFilter->productTypeId,
        ]);

        foreach ($locales as $locale){
            $this->campaignRepository->saveTranslations([
                'campaign_id' => $campaign->id,
                'locale_id' => $locale->id
            ], [
                'title' => $data->get('title')[$locale->code],
                'description' => $data->get('description')[$locale->code],
                'locale_id' => $locale->id,
                'campaign_id' => $campaign->id
            ]);
        }

        return $data->get('campaign_id') ? __('messages.campaignUpdate') : __('messages.campaignCreate');
    }

    public function getParentCategoriesByTypes($request){
        return $this->categoryRepository->parentCategoriesByTypes(['ageTypes' => $request->ageTypes, 'genderTypes' => $request->genderTypes]);
    }

    public function filterProducts($data){
        return $this->productRepository->filterProducts($data);
    }

    public function delete($id){
        return $this->campaignRepository->delete($id);
    }

    public function activeCampaigns(){
        return $this->campaignRepository->activeCampaigns();
    }

    public function getProductsById($id){
        return $this->campaignRepository->getCampaignProducts($id);
    }
}
