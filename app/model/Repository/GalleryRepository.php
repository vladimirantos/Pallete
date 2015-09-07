<?php
namespace App\Model\Repository;
use App\Model\Entity\Entity;
use App\Model\Mapper\Db\GalleryDatabaseMapper;
use App\Model\Mapper\File\ImageMapper;

/**
 * Class GalleryRepository
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Repository
 */
class GalleryRepository extends AbstractRepository {

    const ENTITY = 'Gallery';

    /**
     * @var GalleryDatabaseMapper
     */
    private $galleryDatabaseMapper;

    /**
     * @var ImageMapper
     */
    private $imageMapper;

    /** @var array */
    public $onGallerySave = [];
    
    public function __construct(GalleryDatabaseMapper $databaseMapper, ImageMapper $imageMapper) {
        parent::__construct($databaseMapper);
        $this->galleryDatabaseMapper = $databaseMapper;
        $this->imageMapper = $imageMapper;
    }

    /**
     * @param array $data
     * @return bool|int|\Nette\Database\Table\IRow
     */
    public function insert(array $data) {
        if($data['translate'] != null)
            $data['idGallery'] = $data['translate'];
        else
            $data['idGallery'] = uniqid();
        unset($data['translate']);
        $images = $data['images'];
        unset($data['images']);
        $result = parent::insert($data);
        if($images != null) //složka galerie se vytvoří pouze pokud jsou vkládány obrázky
            $this->onGallerySave($data['idGallery'], $images);
        return $result;
    }

    /**
     * @return Entity
     */
    public function findAll() {
        return $this->bindArray($this->galleryDatabaseMapper->findAll()->order('date DESC, name ASC')->fetchAll(), self::ENTITY);
    }

    /**
     * @param string $lang
     * @return Entity
     * @throws \App\Model\Core\MemberAccessException
     */
    public function findPairsByLang($lang){
        return $this->galleryDatabaseMapper->findAll()->where(['lang' => $lang])->order('date DESC, name ASC, lang ASC')->fetchPairs('idGallery', 'name');
    }
}