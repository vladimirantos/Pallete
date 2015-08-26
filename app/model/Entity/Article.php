<?php
namespace App\Model\Entity;
use Nette\Utils\DateTime;

/**
 * Class Article
 * @author Vladim�r Anto�
 * @version 1.0
 * @package App\Model\Entity
 */
class Article extends Entity {

    /** @var int */
    private $idArticle;

    /** @var string */
    private $lang;

    /** @var User */
    private $author;

    /** @var string */
    private $title;

    /** @var string */
    private $text;

    /** @var string */
    private $image;

    /** @var DateTime */
    private $date;

    /**
     * @return int
     */
    public function getIdArticle() {
        return $this->idArticle;
    }

    /**
     * @param int $idArticle
     * @return Article
     */
    public function setIdArticle($idArticle) {
        $this->idArticle = $idArticle;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return Article
     */
    public function setLang($lang) {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Article
     */
    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Article
     */
    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Article
     */
    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return Article
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
}