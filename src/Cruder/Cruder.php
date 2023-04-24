<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder;

use Cruder\Mysql\MysqlAdapter;

/**
 * CRUD Query Builder
 *
 * @package Cruder 
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license Apache-2.0
 * 
 */
class Cruder implements CrudInterface {

    public $crud;

    /**
     * Constructor
     *
     */
    function __construct() {
        if (Pdo::$set['db_type'] == 'mysql') {
            $this->crud = new MysqlAdapter();
        }
    }

    /**
     * Create
     * 
     * @param string $table table name
     * @return object
     */
    public function create(string $table): object {
        return $this->crud->create($table);
    }

    /**
     * Read
     * 
     * @param string $table table name
     * @return object
     */
    public function read(string $table): object {
        return $this->crud->read($table);
    }

    /**
     * SELECT DISTINCT
     * 
     * @param string $table table name
     * @return object
     */
    public function readDistinct(string $table): object {
        return $this->crud->readDistinct($table);
    }

    /**
     * Update
     * 
     * @param string $table table name
     * @return object
     */
    public function update(string $table): object {
        return $this->crud->update($table);
    }

    /**
     * Delete
     * 
     * @param string $table table name
     * @return object
     */
    public function delete(string $table): object {
        return $this->crud->delete($table);
    }

    /**
     * Set Column
     * 
     * @param string $identificator Column Identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function set(string $identificator, mixed $value): object {
        return $this->crud->set($identificator, $value);
    }

    /**
     * WHERE operator
     * 
     * @param string $identificator WHERE identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function where(string $identificator, mixed $value): object {
        return $this->crud->where($identificator, $value);
    }

    /**
     * AND operator
     * 
     * @param string $identificator AND identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function and(string $identificator, mixed $value): object {
        return $this->crud->and($identificator, $value);
    }

    /**
     * OR operator
     * 
     * @param string $identificator OR identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function or(string $identificator, mixed $value): object {
        return $this->crud->or($identificator, $value);
    }

    /**
     * AS (AS operator)
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function as(string $identificator): object {
        return $this->crud->as($identificator);
    }

    /**
     * GROUP BY identificator
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function groupBy(string $identificator): object {
        return $this->crud->groupBy($identificator);
    }

    /**
     * ORDER BY identificator
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderBy(string $identificator): object {
        return $this->crud->orderBy($identificator);
    }

    /**
     * ORDER BY identificator DESC
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderByDesc(string $identificator): object {
        return $this->crud->orderByDesc($identificator);
    }

    /**
     * LIMIT
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderByAsc(string $identificator): object {
        return $this->crud->orderByAsc($identificator);
    }

    /**
     * LIMIT (LIMIT 10, 2 and etc)
     * 
     * @param string $limit limit text
     * @return object
     */
    public function limit(string $limit): object {
        return $this->crud->limit($limit);
    }

    /**
     * Any operator
     * 
     * @param string $operator Any operator
     * @param string $identificator OR identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function operator(string $operator, string $identificator, mixed $value): object {
        return $this->crud->limit($operator, $identificator, $value);
    }

    /**
     * Get associated array 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectAssoc(string $identificator): object {
        return $this->crud->selectAssoc($identificator);
    }

    /**
     * Get an indexed array 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectIndex(string $identificator): object {
        return $this->crud->selectIndex($identificator);
    }

    /**
     * Get value
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectValue(string $identificator): object {
        return $this->crud->selectValue($identificator);
    }

    /**
     * Get object
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectObj(string $identificator): object {
        return $this->crud->selectObj($identificator);
    }

    /**
     * Count the number of columns 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectColCount(string $identificator): object {
        return $this->crud->selectColCount($identificator);
    }

    /**
     * Count the number of rows 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectRowCount(string $identificator): object {
        return $this->crud->selectRowCount($identificator);
    }

    /**
     * Last Insert Id
     * 
     * @return object
     */
    public function lastInsertId(): object {
        return $this->crud->lastInsertId();
    }

    /**
     * Save
     * 
     * @return mixed
     */
    public function save(): mixed {
        return $this->crud->save();
    }

    /**
     * Install DB-file
     *
     * @param string $path Path to DB
     * @param string $db_prefix Prefix in the database to be replaced with the one set
     * @return mixed
     */
    public static function dbInstall(string $path, string $db_prefix = 'emkt_'): mixed {
        return $this->dbInstall($path, $db_prefix);
    }

}
