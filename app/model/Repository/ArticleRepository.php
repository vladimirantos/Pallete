<?php
namespace App\Model\Repository;
use App\Model\Core\ArgumentException;
use App\Model\Core\EntityExistsException;
use App\Model\Entity\Article;
use App\Model\Entity\Entity;
use App\Model\Languages;
use App\Model\Mapper\Db\ArticleDatabaseMapper;
use App\Model\Mapper\File\ImageMapper;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Http\FileUpload;
use Nette\Utils\Strings;

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
        $image = $data['image'];
        if($image->name == null)
            throw new ArgumentException('Nebyl vložen obrázek');
        unset($data['image']);
        unset($data['idArticle']);
        $name = $this->imageName($image);
        $data['image'] = $name;
        try{
            if($data['translate'] != null)
                $data['idArticle'] = $data['translate'];
            unset($data['translate']);
            $result = parent::insert($data);
        }catch(UniqueConstraintViolationException $ex){
            if($ex->getCode() == 23000)
                throw new EntityExistsException('Článek s tímto nadpisem už existuje');
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
        if($data['image']->name != null){
            $article = $this->find($by['idArticle'], $by['lang']);
            $this->imageMapper->delete($article->image);
            $name = $this->imageName($data['image']);
            $this->insertImage($data['image'], $name);
            $data['image'] = $name;
        }else {
            unset($data['image']);
        }
        if($data['translate'] != null)
            $data['idArticle'] = $data['translate'];
        unset($data['translate']);
        try{
            return parent::update($data, $by);
        }catch (UniqueConstraintViolationException $ex){
            if($ex->getCode() == 23000)
                throw new EntityExistsException('Článek s tímto nadpisem už existuje');
            l($ex->getMessage());
        }
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
     * @param $idArticle
     * @param $lang
     * @return Article
     * @throws \App\Model\Core\MemberAccessException
     */
    public function find($idArticle, $lang){
        return $this->bind($this->articleMapper->findBy(['idArticle' => $idArticle, 'lang' => $lang])->fetch(), self::ENTITY);
    }

    /**
     * @param array $by
     * @return bool
     */
    public function delete(array $by) {
        $article = $this->find($by['idArticle'], $by['lang']);
        if(!$article)
            throw new EntityExistsException('Tento článek neexistuje');
        $this->imageMapper->delete($article->image);
        return parent::delete($by);
    }

    /**
     * @param FileUpload $fileUpload
     * @param string $name
     * @throws \App\Model\Mapper\File\ImageUploadedException
     */
    private function insertImage(FileUpload $fileUpload, $name){
        $this->imageMapper->upload($fileUpload, $name);
    }

    /**
     * @param FileUpload $fileUpload
     * @return string
     */
    private function imageName(FileUpload $fileUpload){
        return Strings::random(8).'-'.$fileUpload->name;
    }
}