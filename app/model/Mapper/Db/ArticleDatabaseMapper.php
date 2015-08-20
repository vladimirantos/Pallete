<?php
namespace App\Model\Mapper\Db;
use Nette\Database\Context;

/**
 * Class ArticleDatabaseMapper
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Mapper\Db
 */
class ArticleDatabaseMapper extends AbstractDatabaseMapper {
    const TABLE = 'articles';

    public function __construct(Context $context) {
        parent::__construct($context, self::TABLE);
    }
}