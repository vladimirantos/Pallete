<?php
namespace App\Model\Mapper\Db;
use Nette\Database\Context;

/**
 * Class OfferDatabaseMapper
 * @author Bruno Puzják
 * @version 1.0
 * @package App\Model\Mapper\Db
 */
class OfferDatabaseMapper extends AbstractDatabaseMapper {
    const TABLE = 'offers';

    public function __construct(Context $context) {
        parent::__construct($context, self::TABLE);
    }
}