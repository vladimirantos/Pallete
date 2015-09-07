<?php
namespace App\Model\Repository;
use App\Model\Core\MemberAccessException;
use App\Model\Entity\Entity;
use App\Model\Mapper\IMapper;
use Nette\Database\Table\IRow;
use Nette\Object;

/**
 * Class AbstractRepository
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Repository
 */
 abstract class AbstractRepository extends Object implements IRepository{

     const ENTITY_PREFIX = 'App\Model\Entity\\';

    /** @var IMapper */
    private $mapper;

    public function __construct(IMapper $mapper) {
        $this->mapper = $mapper;
    }

     /**
      * @param array $data
      * @return bool|int|\Nette\Database\Table\IRow
      */
     function insert(array $data) {
        return $this->mapper->insert($data);
     }

     /**
      * @param array $data
      * @param array $by
      * @return bool
      */
     public function update(array $data, array $by = []) {
         return $this->mapper->update($data, $by);
     }

     /**
      * @param array $by
      * @return bool
      */
     public function delete(array $by) {
         return $this->mapper->delete($by);
     }

     /**
      * @param array $by
      * @param string $column
      * @return int
      */
     public function count(array $by, $column = null) {
         return $this->mapper->findBy($by)->count($column);
     }

     /**
      * Metoda vrací vždy pole.
      * @param array $data
      * @param string $entityName
      * @return Entity
      */
     protected function bindArray($data, $entityName){
        $entityName = self::ENTITY_PREFIX.$entityName;
        if(!class_exists($entityName))
            throw new MemberAccessException('Entity '.$entityName.' not found');
         if(!$data)
             return false;
         $obj = new $entityName;
         if(count($data) < 2 || $data instanceof IRow) { //v poli $data je pouze 1 řádek
             $data = is_array($data) ? array_values($data)[0] : $data;
             foreach ($data as $var => $value) {
                 $obj->$var = $value;
             }
             return [$obj];
         }else{
            $result = [];
            for($i = 0; $i < count($data); $i++) {
                $obj = new $entityName;
                foreach (array_values($data)[$i] as $var => $value) {
                    $obj->$var = $value;
                }
                $result[] = $obj;
            }
            return $result;
         }
     }

     /**
      * Vrací pouze jeden záznam.
      * @param array $data
      * @param string $entityName
      * @return bool
      * @throws MemberAccessException
      */
     protected function bind($data, $entityName) {
         $entityName = self::ENTITY_PREFIX . $entityName;
         if (!class_exists($entityName))
             throw new MemberAccessException('Entity ' . $entityName . ' not found');
         if (!$data)
             return false;
         $obj = new $entityName;
         if (count($data) < 2 || $data instanceof IRow) { //v poli $data je pouze 1 řádek
             $data = is_array($data) ? array_values($data)[0] : $data;
             foreach ($data as $var => $value) {
                 $obj->$var = $value;
             }
             return $obj;
         }
     }
 }