<?php
namespace App\Model\Repository;
use App\Model\Core\EntityExistsException;
use App\Model\Entity\Entity;
use App\Model\Languages;
use App\Model\Mapper\Db\ArticleDatabaseMapper;
use App\Model\Mapper\File\ImageMapper;
use Nette\Database\UniqueConstraintViolationException;

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
     * @param array $data
     * @return bool|int|\Nette\Database\Table\IRow
     * @throws EntityExistsException Pokud existuje článek se stejným nadpisem.
     */
    public function insert(array $data) {
        try{
            return parent::insert($data);
        }catch(UniqueConstraintViolationException $ex){
            if($ex->getCode() == 23000)
                throw new EntityExistsException('Článek s tímto nadpisem už existuje');
            l($ex->getMessage());
        }
        return false;
    }


    /**
     * @return Entity
     */
    public function findAll() {
        return $this->bindArray($this->articleMapper->findAll()->order('date DESC, title ASC, lang ASC')->fetchAll(), self::ENTITY);
    }

    /**
     * @param string $lang
     * @return Entity
     * @throws \App\Model\Core\MemberAccessException
     */
    public function findPairsByLang($lang){
        return $this->articleMapper->findAll()->where(['lang' => $lang])->order('date DESC, title ASC, lang ASC')->fetchPairs('idArticle', 'title');
    }

    /**
     * @param array $by
     * @return Entity|Entity[]
     */
    public function findBy(array $by) {

    }
}