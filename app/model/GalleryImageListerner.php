<?php
namespace App\Model;
use Kdyby\Events\Subscriber;
use Nette\Http\FileUpload;

/**
 * Class GalleryImageListerner
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model
 */
class GalleryImageListerner implements Subscriber {

    public function getSubscribedEvents() {
        return ['App\Model\Repository\GalleryRepository::onGallerySave' => 'uploadImages'];
    }

    /**
     * @param $idGallery
     * @param FileUpload[] $images
     */
    public function uploadImages($idGallery, array $images){
        b($idGallery);
        b($images);
    }
}