<?php


namespace App\Repositories;


use App\Models\Categories\Category;
use App\Repositories\Contractors\CategoryInterface;


class CategoryRepository extends BaseRepository implements CategoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function lastCategoryPosition(){
        $category = $this->model->latest()->first();
        return  $category ? $category->position : 0;
    }

    public function categoryPositionBySlug($slug){
        $category = $this->model->where('slug', $slug)->first();

        return $category ? $category->position : $this->lastCategoryPosition() + 1;
    }

    public function saveTranslations($conditions, $data){
        return $this->find($conditions['category_id'])->translations()->updateOrCreate($conditions, $data);
    }

    public function categoriesWithAdditionals($category_id)
    {
        return $this->find($category_id)->load(['translations','cover','parent', 'genderTypes', 'ageTypes']);
    }

    public function withTranslation(){
        return $this->model->with(['translation'])->get();
    }

    public function groupBySlugWithCount(){
        return $this->model->withCount('products')
                            ->with('translation')
                            ->get();
    }

    public function groupEndChildrenBySlug(){
        return $this->model->selectRaw('slug, position, sum((SELECT count(*) from product_categories pc where pc.category_id=categories.id)) as cnt')
                            ->whereRaw('categories.id not in (Select parent_id from categories as c where c.parent_id is not null)')
                            ->groupBy(['slug', 'position'])->orderBy('position')->get();
    }

    public function updatePositionBySlug($slug, $position){
        return $this->model->where('slug', $slug)->update(['position' => $position]);
    }

    public function syncGenderTypes($category_id, $genderTypes){
        $this->find($category_id)->genderTypes()->sync($genderTypes, true);
    }

    public function syncAgeTypes($category_id, $ageTypes){
        $this->find($category_id)->ageTypes()->sync($ageTypes, true);
    }

    public function getByGenderAndAgeTypes($genderTypeId, $ageTypeId){
        return $this->model
            ->whereHas('genderTypes')
            ->whereHas('ageTypes')
            ->get();
    }

    public function parents(){
        return $this->model->with(['translation', 'children' => function($q){
            $q->with('translation');
        }])->where('parent_id',null)->get();
    }

    public function products($categoryId){
        return $this->find($categoryId)->products;
    }

    public function subCategories($categoryId){
        return $this->find($categoryId)->load(['children' => function ($q){
            $q->with('translation');
        }])->children;
    }

    public function parentCategoriesByTypes($options){
         return $this->model->whereHas('genderTypes', function ($q) use ($options){
                                 $q->when($options['genderTypes'] && count($options['genderTypes']) > 0, function ($q) use ($options){
                                     $q->whereIn('category_gender_type.gender_type_id', $options['genderTypes']);
                                 });
                            })
                             ->whereHas('ageTypes', function ($q) use ($options){
                                 $q->when($options['ageTypes'] && count($options['ageTypes']) > 0, function ($q) use ($options){
                                     $q->whereIn('category_age_type.age_type_id', $options['ageTypes']);
                                 });
                             })
                            ->where('parent_id', null)
                            ->orWhere('parent_id', 0)
                            ->with(['translation', 'children' => function($q){
                                $q->with('translation');
                            }])
                            ->get();

    }
}
