<?php
namespace App\Model;
use App\Model\Repository\GalleryRepository;
use Nette\Http\FileUpload;

/**
 * Class GalleryService
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model
 */
class GalleryService{

    /**
     * @var GalleryRepository
     */
    private $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository) {
        $this->galleryRepository = $galleryRepository;
    }

    public function save(array $data){
        $this->galleryRepository->insert($data);
    }

    public function edit(array $data, $idGallery, $lang){
        $this->galleryRepository->edit($data, $idGallery, $lang);
    }

    /**
     * @param string $idGallery
     * @param string $lang
     * @param FileUpload $image
     */
    public function uploadImage($idGallery, $lang, FileUpload $image){
        $this->galleryRepository->upload($idGallery, $lang, $image);
    }

    public function getGallery($idGallery, $lang){
        return $this->galleryRepository->getGallery($idGallery, $lang);
    }

    /**
     * @return Entity\Entity[]
     */
    public function getAll(){
        return $this->galleryRepository->findAll();
    }

    public function getAllByLang($lang){
        return $this->galleryRepository->findByLang($lang);
    }

    public function getAllGalleryPair(){
        return $this->galleryRepository->findPairsByLang(Languages::CS);
    }

    public function getImages($gallery, $lang){
        return $this->galleryRepository->getFiles($gallery, $lang);
    }

    /**
     * @param string $idGallery
     * @param string $lang
     */
    public function delete($idGallery, $lang){
        $this->galleryRepository->deleteGallery($idGallery, $lang);
    }

    /**
     * @param string $idGallery
     * @param string $lang
     * @param string $image
     */
    public function deleteImage($idGallery, $lang, $image){
        $this->galleryRepository->deleteImage($idGallery, $lang, $image);
    }
}