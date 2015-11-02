<?php
namespace App\Model\Repository;
use App\Model\Core\EntityExistsException;
use App\Model\Entity\Entity;
use App\Model\Entity\Gallery;
use App\Model\Mapper\Db\GalleryDatabaseMapper;
use App\Model\Mapper\File\ImageMapper;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Http\FileUpload;
use Nette\Utils\Strings;

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

    /**
     * Vznikne při změně jazyka nebo ID galerie
     * @var array
     */
    public $onChangePrimary = [];
    
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
        $data['lang'] = $data['language'];
        unset($data['language']);
        unset($data['translate']);
        $images = $data['images'];
        unset($data['images']);
        try{
            $result = parent::insert($data);
        }catch (UniqueConstraintViolationException $ex){
            throw new EntityExistsException('Galerie již existuje');
        }
      //  if($images != null) //složka galerie se vytvoří pouze pokud jsou vkládány obrázky
        $this->onGallerySave($data['idGallery'], $data['lang'], $images);
        return $result;
    }

    public function edit(array $data, $idGallery, $oldLang){
        if($data['translate'] != null)
            $data['idGallery'] = $data['translate'];
        $lang = $data['language'];
        $data['lang'] = $lang;
        unset($data['language']);
        unset($data['translate']);
        $images = $data['images'];
        unset($data['images']);
        try{
            $result = parent::update($data, ['idGallery' => $idGallery, 'lang' => $oldLang]);
        }catch (UniqueConstraintViolationException $ex){
            throw new EntityExistsException('Galerie již existuje');
        }
        if($idGallery != $data['idGallery'] || $oldLang != $data['lang'])
            $this->onChangePrimary($idGallery, $data['idGallery'], $oldLang, $data['lang']);

        if(!empty($images))
            $this->onGallerySave($data['idGallery'], $data['lang'], $images);

        return $result;
    }

    /**
     * @return Gallery
     */
    public function findAll() {
        return $this->bindArray($this->galleryDatabaseMapper->findAll()->order('date DESC, name ASC')->fetchAll(), self::ENTITY);
    }

    /**
     * @param $lang
     * @return Gallery
     * @throws \App\Model\Core\MemberAccessException
     */
    public function findByLang($lang){
        return $this->bindArray($this->galleryDatabaseMapper->findBy(['lang' =>$lang])->order('date DESC, name ASC')->fetchAll(), self::ENTITY);
    }

    /**
     * @param string $lang
     * @return Entity
     * @throws \App\Model\Core\MemberAccessException
     */
    public function findPairsByLang($lang){
        return $this->galleryDatabaseMapper->findAll()->where(['lang' => $lang])->order('date DESC, name ASC, lang ASC')->fetchPairs('idGallery', 'name');
    }

    public function upload($idGallery, $lang, FileUpload $fileUpload){
        $name = Strings::random(8).'-'.$fileUpload->name;
        $this->imageMapper->upload($fileUpload, galleryPath.$idGallery.'_'.$lang.DIRECTORY_SEPARATOR.$name);
    }

    public function getFiles($gallery, $lang){
        return $this->imageMapper->getFiles(galleryPath.$gallery.'_'.$lang);
    }

    /**
     * @param string $idGallery
     * @param string $lang
     * @return bool
     * @throws \App\Model\Core\MemberAccessException
     */
    public function getGallery($idGallery, $lang){
        return $this->bind($this->galleryDatabaseMapper->findBy(['idGallery' => $idGallery, 'lang' => $lang])->fetch(), self::ENTITY);
    }

    /**
     * @param string $idGallery
     * @param string $lang
     */
    public function deleteGallery($idGallery, $lang){
        $this->galleryDatabaseMapper->delete(['idGallery' => $idGallery, 'lang' => $lang]);
        $this->imageMapper->deleteFolder(galleryPath.$idGallery.'_'.$lang);
    }

    /**
     * @param string $idGallery
     * @param string $lang
     * @param string $image
     */
    public function deleteImage($idGallery, $lang, $image){
        $this->imageMapper->delete(galleryPath.$idGallery.'_'.$lang.DIRECTORY_SEPARATOR.$image);
    }
}