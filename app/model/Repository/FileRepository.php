<?php
namespace App\Model\Repository;
use App\Model\Entity\Entity;

/**
 * Class FileRepository
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Repository
 */
class FileRepository extends AbstractRepository {

    public function __construct() {

    }

    /**
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return Entity
     */
    function findAll($order = null, $limit = null, $offset = null)
    {

    }

    /**
     * @param array $by
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return Entity|Entity[]
     */
    function findBy(array $by, $order = null, $limit = null, $offset = null)
    {

    }
}