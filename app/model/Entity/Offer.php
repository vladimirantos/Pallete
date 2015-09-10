<?php

namespace App\Model\Entity;

/**
 * Class Offer
 * @author Bruno Puzják
 * @version 1.0
 * @package App\Model\Entity
 */
class Offer extends Entity {

    private $title;
    private $lang;
    private $author;
    private $text;
    private $image;
    private $keywords;
    private $description;
    private $date;

    function getTitle() {
        return $this->title;
    }

    function getLang() {
        return $this->lang;
    }

    function getAuthor() {
        return $this->author;
    }

    function getText() {
        return $this->text;
    }

    function getImage() {
        return $this->image;
    }

    function getKeywords() {
        return $this->keywords;
    }

    function getDescription() {
        return $this->description;
    }

    function getDate() {
        return $this->date;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setLang($lang) {
        $this->lang = $lang;
    }

    function setAuthor($author) {
        $this->author = $author;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setDate($date) {
        $this->date = $date;
    }

    public function toArray() {
        $data = [];
        foreach ($this as $k => $v)
            $data[$k] = $v;
        return $data;
    }

}
