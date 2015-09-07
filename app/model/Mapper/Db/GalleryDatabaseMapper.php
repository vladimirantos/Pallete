<?php
namespace App\Model\Mapper\Db;
use Nette\Database\Context;

/**
 * Class GalleryDatabaseMapper
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Mapper\Db
 */
class GalleryDatabaseMapper extends AbstractDatabaseMapper {
    const TABLE = 'galleries';

    public function __construct(Context $context) {
        parent::__construct($context, self::TABLE);
    }
}