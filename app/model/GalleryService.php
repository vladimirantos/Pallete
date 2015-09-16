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

    /**
     * @param string $gallery
     * @param FileUpload $image
     */
    public function uploadImage($gallery, FileUpload $image){
        $this->galleryRepository->upload($gallery, $image);
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

    public function getAllArticlesPair(){
        return $this->galleryRepository->findPairsByLang(Languages::CS);
    }

    public function getImages($gallery){
        return $this->galleryRepository->getFiles($gallery);
    }
}