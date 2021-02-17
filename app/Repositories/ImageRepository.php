<?php


namespace App\Repositories;


use App\Repositories\Contractors\ImageRepositoryInterface;
use App\Models\Images\Image;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

    public function delete($id){
        return $this->find($id)->delete();
    }

    public function findByPath($image_name){
        return $this->model->where('path', $image_name)->first();
    }
}
