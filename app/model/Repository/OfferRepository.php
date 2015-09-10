<?php

namespace App\Model\Repository;

use App\Model\Mapper\Db\OfferDatabaseMapper;
use App\Model\Mapper\File\ImageMapper;

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

    public function findAll() {
        return $this->bindArray($this->offerMapper->findAll()->order('date DESC, title ASC, lang ASC')->fetchAll(), self::ENTITY);
    }

    /**
     * @param string $lang
     * @return Entity
     * @throws \App\Model\Core\MemberAccessException
     */
    public function findPairsByLang($lang) {
        return $this->offerMapper->findAll()->where(['lang' => $lang])->order('date DESC, title ASC, lang ASC')->fetchPairs('title', 'lang');
    }

}
