<?php
namespace App\Model\Repository;
use App\Model\Entity\Entity;
use App\Model\Mapper\Db\ArticleDatabaseMapper;
use App\Model\Mapper\File\ImageMapper;

/**
 * Class ArticleRepository
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Repository
 */
class ArticleRepository extends AbstractRepository {

    /** @var  ArticleDatabaseMapper */
    private $articleMapper;

    /** @var ImageMapper */
    private $imageMapper;

    const ENTITY = 'Article';

    public function __construct(ArticleDatabaseMapper $articleDatabaseMapper, ImageMapper $imageMapper) {
        parent::__construct($articleDatabaseMapper);
        $this->articleMapper = $articleDatabaseMapper;
        $this->imageMapper = $imageMapper;
    }

    /**
     * @return Entity
     */
    public function findAll() {
        return $this->bind($this->articleMapper->findAll()->order('date DESC, title ASC, lang ASC')->fetchAll(), self::ENTITY);
    }

    /**
     * @param array $by
     * @return Entity|Entity[]
     */
    public function findBy(array $by) {

    }
}