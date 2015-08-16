<?php
namespace App\Model\Mapper\Db;
use Nette\Database\Context;

/**
 * Class UserDatabaseMapper
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Mapper\Db
 */
class UserDatabaseMapper extends AbstractDatabaseMapper{

    const TABLE = 'users';

    public function __construct(Context $context) {
        parent::__construct($context, self::TABLE);
    }
}