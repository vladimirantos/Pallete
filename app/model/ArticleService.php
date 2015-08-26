<?php
namespace App\Model;
use App\Model\Core\EntityExistsException;
use App\Model\Core\NotFoundException;
use App\Model\Entity\Article;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\FileRepository;

/**
 * Class ArticleService
 * @author Vladim�r Anto�
 * @version 1.0
 * @package App\Model
 */
class ArticleService
{
    /** @var ArticleRepository */
    private $articleRepository;

    /** @var FileRepository */
    private $fileRepository;

    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param array $data
     * @throws EntityExistsException Pokud existuje �l�nek se stejn�m nadpisem.
     */
    public function save(array $data){
        if(isset($data['translate'])){
            $data['idArticle'] = $data['translate'];
            unset($data['translate']);
        }
        return $this->articleRepository->insert($data);
    }

    /**
     * Vr�t� �l�nek na z�klad� jeho ID a jazykov� verze.
     * @param int $id
     * @param string $lang
     * @return Article
     * @throws NotFoundException
     */
    public function getArticle($id, $lang){

    }

    /**
     * @param int $id
     * @param string $lang
     */
    public function delete($id, $lang){

    }

    /**
     * @return Article[]
     */
    public function getAllArticles(){
        return $this->articleRepository->findAll();
    }

    public function getAllArticlesPair(){
        return $this->articleRepository->findPairsByLang(Languages::CS);
    }
}