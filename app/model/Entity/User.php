<?php
namespace App\Model\Entity;
use Nette\Utils\DateTime;

/**
 * Class User
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Entity
 */
class User extends Entity {

    /** @var int */
    private $idUser;

    /** @var string */
    private $name;

    /** @var string */
    private $lastName;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $access;

    /** @var DateTime */
    private $regDate;

    /**
     * @return int
     */
    public function getIdUser() {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     * @return User
     */
    public function setIdUser($idUser) {
        $this->idUser = $idUser;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccess() {
        return $this->access;
    }

    /**
     * @param string $access
     * @return User
     */
    public function setAccess($access) {
        $this->access = $access;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getRegDate() {
        return $this->regDate;
    }

    /**
     * @param DateTime $regDate
     * @return User
     */
    public function setRegDate($regDate) {
        $this->regDate = $regDate;
        return $this;
    }

    /**
     * @return string
     */
    public function toString() {
        return $this->name.' '.$this->lastName;
    }
}