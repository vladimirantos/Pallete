<?php
namespace App\Model\Repository;

use App\Model\Entity\Entity;
use Nette\Database\Table\Selection;

/**
 * Základní rozhraní pro repository. Přijímá data od Service a předává je Mapperu. Při získávání dat z mapperu přetypuje data na entitu.
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Repository
 */
interface IRepository {

    /**
     * @param array $data
     * @return bool|int|\Nette\Database\Table\IRow
     */
    function insert(array $data);

    /**
     * @param array $data
     * @param array $by
     * @return bool
     */
    function update(array $data, array $by = []);

    /**
     * @param array $by
     * @return bool
     */
    function delete(array $by);


    /**
     * @return Entity
     */
    function findAll();

//    /**
//     * @param array $by
//     * @return Entity|Entity[]
//     */
//    function findBy(array $by);

//
//    /**
//     * @param string $order
//     * @param int $limit
//     * @param int $offset
//     * @return Entity
//     */
//    function findAll($order = null, $limit = null, $offset = null);
//
//    /**
//     * @param array $by
//     * @param string $order
//     * @param int $limit
//     * @param int $offset
//     * @return Entity|Entity[]
//     */
//    function findBy(array $by, $order = null, $limit = null, $offset = null);

    /**
     * @param array $by
     * @param string $column
     * @return int
     */
    function count(array $by, $column = null);
}