<?php


namespace App\Services;


use App\Helpers\ActionHelper;
use App\Models\Categories\Category;
use App\Models\Images\Image;
use App\Repositories\AgeTypeRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GenderTypeRepository;
use App\Repositories\ImageRepository;
use App\Repositories\LocaleRepository;

class CategoryService
{
    use ActionHelper;

    protected $categoryRepository,
              $localeRepository,
              $imageRepository,
              $genderTypeRepository,
              $ageTypeRepository
    ;

    public function __construct(CategoryRepository $categoryRepository,
                                LocaleRepository $localeRepository,
                                ImageRepository $imageRepository,
                                GenderTypeRepository $genderTypeRepository,
                                AgeTypeRepository $ageTypeRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->localeRepository = $localeRepository;
        $this->imageRepository = $imageRepository;
        $this->genderTypeRepository = $genderTypeRepository;
        $this->ageTypeRepository = $ageTypeRepository;
    }

    public function index(){
        return [
            'locales' => $this->localeRepository->all(),
            'genderTypes' => $this->genderTypeRepository->all(),
            'ageTypes' => $this->ageTypeRepository->all(),
            'categories' => $this->categoryRepository->all(),
            'parentCategories' => $this->categoryRepository->parents()
        ];
    }

    public function getGroup(){
        return [
            'categoryGroups' => $this->categoryRepository->groupEndChildrenBySlug(),
        ];
    }

    public function delete($category_id){
        $this->categoryRepository->find($category_id)->delete();
    }

    public function save($request){
        $data = $request->except(['_token', 'name']);

        $data['position'] = $this->categoryRepository->categoryPositionBySlug($request->slug);

        if ($request->has('cover')) {
            $imagePath = $this->uploadImage($request->file('cover'), Category::COVER_PATH);

            $data['cover_image_id'] = $this->imageRepository->save($request->get('image_id'), [
                'path' => $imagePath,
                'type' => Image::CATEGORY_TYPE
            ])->id;
        }

        $category = $this->categoryRepository->save($request->get('category_id'), $data);

        $this->categoryRepository->syncGenderTypes($category->id, $request->genderTypes);
        $this->categoryRepository->syncAgeTypes($category->id, $request->ageTypes);

        $locales = $this->localeRepository->all();

        foreach ($locales as $locale){
            $this->categoryRepository->saveTranslations([
                'category_id' => $category->id,
                'locale_id' => $locale->id
            ], [
                'name' => $request->get('name')[$locale->code],
                'locale_id' => $locale->id,
                'category_id' => $category->id
            ]);
        }

        return $request->get('category_id') ? __('messages.categoryUpdate') : __('messages.categoryCreate');
    }

    public function edit($category_id){
        return $this->categoryRepository->categoriesWithAdditionals($category_id);
    }

    public function getAll(){
        return $this->categoryRepository->all();
    }

    public function getGenderTypes(){
        return $this->genderTypeRepository->withTranslation();
    }


    public function getAgeTypes(){
        return $this->ageTypeRepository->withTranslation();
    }

    public function updatePosition($request){
        foreach ($request->slugs as $key => $slug){
            $this->categoryRepository->updatePositionBySlug($slug['slug'], $request->positions[$key]['position']);
        }
    }

    public function getByTypes($request){
        return $this->categoryRepository->getByGenderAndAgeTypes($request->genderType, $request->ageType);
    }

    public function getSubCategories($categoryId){
        return $this->categoryRepository->subCategories($categoryId);
    }
}
