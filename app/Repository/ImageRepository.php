<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;
use Symfony\Component\HttpFoundation\Response;

class ImageRepository
{
    /**
     * Upload the image
     * @param $image
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function uploadImage($image, $path = 'images', $name=null)
    {
        return $this->upload($image,$path, $name);
    }
    /**
     * Upload the image
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function upload($image,$path = 'images', $name=null)
    {
        try{
            $name == null ? $name = uniqid() : $name = $name;
            $path = Storage::disk('public')->put($path, $image);
            $uploadedImage = Image::create([
                'path' => $path,
                'name' => $name,
            ]);
            return $uploadedImage;
        }catch (\Exception $exception){
            return response('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
