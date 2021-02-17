<?php


namespace App\Services;


use App\Helpers\ActionHelper;
use App\Repositories\ImageRepository;

class ImageService
{
    use ActionHelper;

    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function upload($image, $options){
        $data = [
            'type' => $options['type'],
        ];
        if($image){
            $data['path'] = $this->uploadImage($image, $options['dir']);
        }
        return $this->imageRepository->save($options['id'], $data);
    }

    public function get($image_id){
        return $this->imageRepository->find($image_id);
    }

    public function remove($image_name){

        return $this->imageRepository->delete(
            $this->imageRepository->findByPath($image_name)->id
        );
    }
}
