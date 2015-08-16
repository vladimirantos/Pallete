<?php
namespace App\Model\Repository;

use App\Model\Entity\Entity;
use App\Model\Mapper\Db\UserDatabaseMapper;

interface IUserRepository extends IRepository{

    /**
     * @param int $id
     * @return Entity
     */
    function findById($id);
}

/**
 * Class UserRepository
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Repository
 */
class UserRepository extends AbstractRepository implements IUserRepository {

    const ENTITY = 'User';

    const PRIMARY = 'idUser';

    /** @var UserDatabaseMapper */
    private $mapper;

    /**
     * @param UserDatabaseMapper $userDatabaseMapper
     */
    public function __construct(UserDatabaseMapper $userDatabaseMapper) {
        parent::__construct($userDatabaseMapper);
        $this->mapper = $userDatabaseMapper;
    }

    /**
     * @return Entity
     */
    public function findAll($order = null, $limit = null, $offset = null) {
        $result = $this->mapper->findAll();
        if($order)
            $result->order($order);
        if($limit)
            $result->limit($limit, $offset);
        return $this->bind(
            $result->fetchAll(),
            self::ENTITY
        );
    }

    /**
     * @param array $by
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return Entity|Entity[]
     */
    public function findBy(array $by, $order = null, $limit = null, $offset = null) {
        $result = $this->mapper->findBy($by);
        if($order)
            $result->order($order);
        if($limit)
            $result->limit($limit, $offset);
        return $this->bind(
            $result->fetchAll(),
            self::ENTITY
        );
    }

    /**
     * @param int $id
     * @return Entity
     */
    public function findById($id) {
        return $this->bind(
            $this->mapper->findBy([self::PRIMARY => $id])->fetch(),
            self::ENTITY
        );
    }
}