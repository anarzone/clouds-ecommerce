<?php


namespace App\Repositories\Contractors;


interface CategoryInterface
{
    public function lastCategoryPosition();
    public function save($id, $data);
    public function saveTranslations($id, $data);
    public function categoriesWithAdditionals($category_id);
}
