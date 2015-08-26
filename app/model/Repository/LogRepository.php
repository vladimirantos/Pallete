<?php
namespace App\Model\Repository;

use App\Model\Entity\Entity;
use App\model\Mapper\Db\LogDbMapper;

interface ILogRepository extends IRepository{

    /**
     * @param string $email
     * @param int $ip
     * @return bool|int|\Nette\Database\Table\IRow
     */
    function insertToLog($email, $ip);
}

/**
 * Class LogRepository
 * @author Vladimír Antoš
 * @version 1.0
 * @package app\model\Repository
 */
class LogRepository extends AbstractRepository implements ILogRepository
{
    /** @var LogDbMapper */
    private $mapper;

    public function __construct(LogDbMapper $logDbMapper) {
        parent::__construct($logDbMapper);
        $this->mapper = $logDbMapper;
    }

    /**
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return Entity
     */
    public function findAll($order = null, $limit = null, $offset = null) {

    }

    /**
     * @param array $by
     * @param string $order
     * @param int $limit
     * @param int $offset
     * @return Entity|Entity[]
     */
    public function findBy(array $by, $order = null, $limit = null, $offset = null) {

    }

    /**
     * @param string $email
     * @param int $ip
     * @return bool|int|\Nette\Database\Table\IRow
     */
    public function insertToLog($email, $ip) {
        return $this->mapper->insertToLog($email, $ip);
    }
}