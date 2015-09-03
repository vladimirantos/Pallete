<?php
namespace App\Model;
use App\Model\Core\EntityExistsException;
use App\Model\Core\NotFoundException;
use App\Model\Entity\Article;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\FileRepository;

/**
 * Class ArticleService
 * @author Vladimír Antoš
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
     * @throws EntityExistsException Pokud existuje článek se stejným nadpisem.
     */
    public function save(array $data){
//        if($data['idArticle'] != null) {
//            $idArticle = $data['idArticle'];
//            $lang = $data['lang'];
//            unset($data['idArticle']);
//            unset($data['lang']); //todo vyjmutí prvku z pole podle klíče
//            return $this->articleRepository->update($data, $idArticle, $lang);
//        }
            return $this->articleRepository->insert($data);
    }

    public function edit(array $data, $idArticle, $lang){
        return $this->articleRepository->update($data, ['idArticle' => $data['idArticle'], 'lang' => $data['lang']]);
    }

    /**
     * Vrátí článek na základě jeho ID a jazykové verze.
     * @param int $id
     * @param string $lang
     * @return Article
     * @throws NotFoundException
     */
    public function getArticle($id, $lang){
        return $this->articleRepository->find($id, $lang);
    }

    /**
     * @param int $id
     * @param string $lang
     */
    public function delete($id, $lang){
        $this->articleRepository->delete(['idArticle' => $id, 'lang' => $lang]);
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