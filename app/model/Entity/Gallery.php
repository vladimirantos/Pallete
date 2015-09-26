<?php
namespace App\Model\Entity;
use Nette\Utils\DateTime;

/**
 * Class Gallery
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Entity
 */
class Gallery extends Entity {
    /** @var int */
    private $idGallery;

    /** @var string */
    private $lang;

    /** @var string */
    private $name;

    /** @var string */
    private $text;

    /** @var DateTime */
    private $date;

    /**
     * @return int
     */
    public function getIdGallery()
    {
        return $this->idGallery;
    }

    /**
     * @param int $idGallery
     * @return Gallery
     */
    public function setIdGallery($idGallery)
    {
        $this->idGallery = $idGallery;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return Gallery
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Gallery
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return Gallery
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function toString() {
        return $this->name;
    }
     public function toArray() {
        $data = [];
        foreach ($this as $k => $v)
            $data[$k] = $v;
        return $data;
    }


}