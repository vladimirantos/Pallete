<?php


namespace App\Model\Core;
use Nette\Object;

/**
 * Porovnává zadaný objekt s aktuálním.
 * Vrací:
 *  -1 aktuální objekt větší než zadaný
 *   0 jsou si oba objekty rovny
 *   1 zadaný objekt je větší než aktuální
 */
interface IComparable{

    /**
     * @param SObject $obj
     * @return int
     */
    function compareTo(SObject $obj);
}

/**
 * Umožňuje vytvořit novou instanci třídy se stejnými hodnotami jako je existující.
 */
interface ICloneable{

    /**
     * @return SObject
     */
    function cloneObject();
}

/**
 * Umožňuje uvolnit objektu paměť.
 */
interface IDisposable{
    function dispose();
}

/**
 * Podpora serializace objektu.
 */
interface ISerializable{

    /**
     * @return string
     */
    function serialize();

    /**
     * @param string $string
     * @return SObject
     */
    function unserialize($string);
}

/**
 * @author Vladimír Antoš
 * @version 1.0.0
 */
abstract class SObject extends Object{

    /**
     * @param mixed $obj
     * @return bool
     */
    public function equals(SObject $obj) {
        return $this == $obj;
    }

    /**
     * Metoda zjištuje, jestli jsou objekty stejné.
     * @param object $obj
     * @return bool
     */
    final public function instanceEquals(object $obj) {
        return $this === $obj;
    }

    /**
     * Vrací typ zadané proměnné. Pokud je proměnná neznámého typu, metoda vrací false.
     * @param mixed $var
     * @return string
     */
    final public function type($var) {
        return gettype($var);
    }

    /**
     * Vrací název zadané třídy.
     * @param Object $obj
     * @param bool $onlyName Pokud je false, metoda vrací název včetně jmeného prostoru.
     * @return string
     */
    final public function getClassType($obj, $onlyName = true) {
        $classname = get_class($obj);
        if ($onlyName && preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }
        return $classname;
    }

    /**
     * Vrací hash hodnotu objektu.
     * @return string
     */
    public function getHashCode() {
        return spl_object_hash($this);
    }

    /**
     * @return int
     */
    public function getTime() {
        return time();
    }

    /**
     * @return string
     */
    public function toString() {
        return get_class($this);
    }

    /**
     * @return string
     */
    public function serialize() {
        return serialize($this);
    }

    /**
     * @param string $string
     * @return SObject
     */
    public function unserialize($string) {
        return unserialize($string);
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->toString();
    }

    /**
     * @return SObject
     * @throws MemberAccessException
     */
    public function __clone() {
        if(!($this instanceof ICloneable))
            throw new MemberAccessException("Unimplemented interface ICloneable");
        return $this->cloneObject();
    }
}