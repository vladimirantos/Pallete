<?php
namespace App\Model\Entity;
use App\Model\Core\SObject;

/**
 * Class AbstractEntity
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Entity
 */
class Entity extends SObject{

    public function __construct() {

    }

    public function toArray(){
        $data = [];
        foreach($this as $k => $v)
            $data[$k] = $v;
        return $data;
    }
}