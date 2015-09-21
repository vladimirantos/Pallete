<?php

namespace App\Model\Repository;

use App\Model\Mapper\Db\OfferDatabaseMapper;
use App\Model\Mapper\File\ImageMapper;
use App\Model\Core\ArgumentException;
use Nette\Http\FileUpload;
use Nette\Utils\Strings;
use Nette\Database\UniqueConstraintViolationException;
use App\Model\Core\EntityExistsException;

/**
 * Class OfferRepository
 * @author Bruno Puzják
 * @version 1.0
 * @package App\Model\Repository
 */
class OfferRepository extends AbstractRepository {

    /** @var  OfferDatabaseMapper */
    private $offerMapper;

    /** @var ImageMapper */
    private $imageMapper;

    const ENTITY = 'Offer';

    public function __construct(OfferDatabaseMapper $offerDatabaseMapper, ImageMapper $imageMapper) {
        parent::__construct($offerDatabaseMapper);
        $this->offerMapper = $offerDatabaseMapper;
        $this->imageMapper = $imageMapper;
    }

    /**
     * @param $title
     * @param $lang
     * @return Offer
     * @throws \App\Model\Core\MemberAccessException
     */
    public function find($idOffer, $lang) {
        return $this->bind($this->offerMapper->findBy(['idOffer' => $idOffer, 'lang' => $lang])->fetch(), self::ENTITY);
    }

    public function findAll() {
        return $this->bindArray($this->offerMapper->findAll()->order('date DESC, title ASC, lang ASC')->fetchAll(), self::ENTITY);
    }

    /**
     * @param string $lang
     * @return Entity
     * @throws \App\Model\Core\MemberAccessException
     */
    public function findPairsByLang($lang) {
        return $this->offerMapper->findAll()->where(['lang' => $lang])->order('date DESC, title ASC, lang ASC')->fetchPairs('idOffer', 'title');
    }

    /**
     * @param array $data
     * @return bool|int|\Nette\Database\Table\IRow
     * @throws EntityExistsException Pokud existuje článek se stejným nadpisem.
     */
    public function insert(array $data) {
        $image = $data['image'];
        if ($image->name == null)
            throw new ArgumentException('Nebyl vložen obrázek');
        unset($data['image']);
        unset($data['idOffer']);
        $name = $this->imageName($image);
        $data['image'] = $name;
        try {
            if ($data['translate'] != null)
                $data['idOffer'] = $data['translate'];
            unset($data['translate']);
            $result = parent::insert($data);
        } catch (UniqueConstraintViolationException $ex) {
            if ($ex->getCode() == 23000)
                throw new EntityExistsException('Nabídka s tímto nadpisem už existuje');
            l($ex->getMessage());
        }
        $this->insertImage($image, $name);
        return $result;
    }

    /**
     * @param array $data
     * @param array $by
     * @return bool
     */
    public function update(array $data, array $by = []) {
        if ($data['image']->name != null) {
            $article = $this->find($by['idOffer'], $by['lang']);
            $this->imageMapper->delete($article->image);
            $name = $this->imageName($data['image']);
            $this->insertImage($data['image'], $name);
            $data['image'] = $name;
        } else {
            unset($data['image']);
        }
        if ($data['translate'] != null)
            $data['idOffer'] = $data['translate'];
        unset($data['translate']);
        try {
            return parent::update($data, $by);
        } catch (UniqueConstraintViolationException $ex) {
            if ($ex->getCode() == 23000)
                throw new EntityExistsException('Nabídka s tímto nadpisem už existuje');
            l($ex->getMessage());
        }
    }

    /**
     * @param FileUpload $fileUpload
     * @param string $name
     * @throws \App\Model\Mapper\File\ImageUploadedException
     */
    private function insertImage(FileUpload $fileUpload, $name) {
        $this->imageMapper->upload($fileUpload, articleImagesPath . $name);
    }

    /**
     * @param FileUpload $fileUpload
     * @return string
     */
    private function imageName(FileUpload $fileUpload) {
        return Strings::random(8) . '-' . $fileUpload->name;
    }

}
