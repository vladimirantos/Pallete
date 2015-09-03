<?php
namespace App\Model\Mapper\Db;
use App\Model\Mapper\IMapper;
use Nette\Database\Context;
use Nette\Database\Table\Selection;

/**
 * Poskytuje základní metody přístupu k databázi.
 * @author Vladimír Antoš
 * @version 1.0
 * @package App\Model\Mapper
 */
abstract class AbstractDatabaseMapper implements IMapper{

    /** @var Context */
    protected $context;

    /**
     * @var Selection
     */
    protected $database;

    /** @var string */
    protected $table;

    /**
     * @param Context $context
     * @param string $table
     */
    public function __construct(Context $context, $table) {
        $this->context = $context;
        $this->table = $table;
        $this->database = $this->context->table($this->table);
    }

    /**
     * @param array $data
     * @return bool|int|\Nette\Database\Table\IRow
     */
    public function insert(array $data) {
        return $this->context->table($this->table)->insert($data);
    }

    /**
     * @param array $data
     * @param array $by
     * @return bool
     */
    public function update(array $data, array $by = []) {
        return $this->context->table($this->table)->where($by)->update($data);
//        return $this->database->where($by)->update($data);
    }

    /**
     * @param array $by
     * @return bool
     */
    public function delete(array $by) {
        return $this->context->table($this->table)->where($by)->delete();
    }

    /**
     * @return Selection
     */
    public function findAll() {
        return $this->context->table($this->table);
    }

    /**
     * @param array $by
     * @return Selection
     */
    public function findBy(array $by) {
        return $this->context->table($this->table)->where($by);
    }

    /**
     * @param array $by
     * @param string $column
     * @return int
     */
    public function count(array $by, $column = null) {
        return $this->context->table($this->table)->where($by)->count();
    }
}