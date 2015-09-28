<?php
namespace App\Model;
use App\Model\Repository\GalleryRepository;
use Kdyby\Events\Subscriber;
use Nette\Http\FileUpload;
use Nette\Utils\FileSystem;

/**
 * Class GalleryImageListerner
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model
 */
class GalleryImageListerner implements Subscriber {

    /**
     * @var GalleryRepository
     */
    private $gallery;

    /**
     * @param GalleryRepository $service
     */
    public function __construct(GalleryRepository $service){
        $this->gallery = $service;
    }


    public function getSubscribedEvents() {
        return ['App\Model\Repository\GalleryRepository::onGallerySave' => 'uploadImages',
                'App\Model\Repository\GalleryRepository::onChangePrimary' => 'renameGallery'];
    }

    /**
     * @param $idGallery
     * @param FileUpload[] $images
     */
    public function uploadImages($idGallery, $lang, array $images){
        FileSystem::createDir(galleryPath.$idGallery.'_'.$lang);
        if(!empty($images))
            foreach($images as $image){
                $this->gallery->upload($idGallery, $lang, $image);
            }
    }

    /**
     * @param string $oldIdGallery
     * @param string $newIdGallery
     * @param string $oldLang
     * @param string $newLang
     */
    public function renameGallery($oldIdGallery, $newIdGallery, $oldLang, $newLang){
        b($oldIdGallery, 'oI');
        b($newIdGallery, 'nI');
        b($oldLang, 'oL');
        b($newLang, 'nL');
        FileSystem::rename(galleryPath.$oldIdGallery.'_'.$oldLang, galleryPath.$newIdGallery.'_'.$newLang);
    }
}