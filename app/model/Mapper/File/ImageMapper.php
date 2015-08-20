<?php
namespace App\Model\Mapper\File;
use Nette\Database\Table\Selection;

/**
 * Class ImageMapper
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Mapper\File
 */
class ImageMapper extends AbstractFileMapper {

    public function __construct() {

    }

    /**
     * @param array $data
     * @return bool|int|\Nette\Database\Table\IRow
     */
    function insert(array $data)
    {

    }

    /**
     * @param array $data
     * @param array $by
     * @return bool
     */
    function update(array $data, array $by = [])
    {

    }

    /**
     * @param array $by
     * @return bool
     */
    function delete(array $by)
    {

    }

    /**
     * @return Selection
     */
    function findAll()
    {

    }

    /**
     * @param array $by
     * @return Selection
     */
    function findBy(array $by)
    {

    }

    /**
     * @param array $by
     * @param string $column
     * @return int
     */
    function count(array $by, $column = null)
    {

    }
}