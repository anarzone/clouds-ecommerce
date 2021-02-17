<?php

namespace App\Helpers;

use App\Http\Resources\Api\V1\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;

trait ActionHelper
{
    private function uploadImage($img, $directory)
    {
        $time = Carbon::now();
        $extension = $img->getClientOriginalExtension();
        $directory = $directory . '/' . date_format($time, 'Y') . '/' . date_format($time, 'm') . '/' . date_format($time, 'd');
        $filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;

        $store_Image = $img->storeAs($directory, $filename, 'public');
        $image_path = $directory . '/' . $filename;

        return $store_Image ? $image_path : false;
    }

    private function modifyCategories($categories)
    {
        $data = array();

        foreach ($categories as $category) {
            $data[$category->id]['id'] = $category->id;
            $data[$category->id]['name'] = $category->translation->name;
            $data[$category->id]['parent_id'] = (int)$category->parent_id;
            $data[$category->id]['parentName'] = $category->parent_id ? $category->parent->translation->name : null;
            $data[$category->id]['level'] = 1;
            $data[$category->id]['isParent'] = count($category->children) > 0;
        }


//        foreach ($data as $cat){
//            if (array_key_exists($cat['parent_id'], $data)) {
//                $data[$cat['id']]['level'] = $data[$cat['parent_id']]['level'] + 1;
//            }
//        }

//        $data = $this->buildTree($data);
//
//        $catData = [];


        return $data;
    }

    private function buildTree($categories, $parentId = 0, $level=1)
    {
        $branch = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $children = $this->buildTree($categories, $category['id']);

                if ($children) {
                    $category['children'] = $children;
                }

                $branch[] = $category;
            }
        }

        return $branch;
    }

    private function iterateCategories($categories, array $data, $parent=null)
    {
        foreach ($categories as $category){
            if (gettype($category) == 'array'){
                if($parent){
                    $data[] = $parent;
                }
                $data[] = $category;
            }

            $this->iterateCategories($category, $data);
        }
    }

    public function mapMainCategories($categories){
        $mapped = [];
        foreach ($categories as $category){
            $mapped[$category->id] = (new Category($category))->resolve();
            foreach ($category->children as $child){
                $mapped[$child->parent_id]['sub'][] = new Category($child);
            }
        }

        return $mapped;
    }

    public function mapCampaignFilter($filter){
        if($filter){
            return [
                'campaign_id' => $filter->campaign_id,
                'age_type_ids' => explode(',',$filter->age_type_ids),
                'gender_type_ids' => explode(',',$filter->gender_type_ids),
                'category_ids' => explode(',',$filter->category_ids),
                'brand_id' => $filter->brand_id,
                'product_type_id' => $filter->product_type_id,
            ];
        }else{
            return null;
        }
    }

    public function mapCampaignProducts($products){
        $ids = [];
        foreach ($products as $product){
            $ids[] = $product->id;
        }

        return $ids;
    }
}
