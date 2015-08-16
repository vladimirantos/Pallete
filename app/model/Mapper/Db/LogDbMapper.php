<?php
namespace App\Model\Mapper\Db;
use Nette\Database\Context;

/**
 * Class LogDbMapper
 * @author Vladimír Antoš
 * @version 1.0
 * @package app\model\Mapper\Db
 */
class LogDbMapper extends AbstractDatabaseMapper {
    const TABLE = 'signLog';
    public function __construct(Context $context) {
        parent::__construct($context, self::TABLE);
    }

    /**
     * @param int $idUser
     * @param int $ip
     * @return bool|int|\Nette\Database\Table\IRow
     */
    public function insertToLog($idUser, $ip){
        return $this->database->insert(['idUser' => $idUser, 'ip' => $ip]);
    }
}