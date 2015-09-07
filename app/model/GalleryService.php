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
     * @param FileUpload[] $images
     */
    public function uploadImages(array $images){

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
}