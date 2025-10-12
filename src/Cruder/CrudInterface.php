<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder;

/**
 * Crud Interface
 *
 * @package Cruder
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license Apache-2.0
 * 
 */
interface CrudInterface {

    /**
     * Create
     * 
     * @param string $table table name
     * @return object
     */
    public function create(string $table): object;

    /**
     * Read
     * 
     * @param string $table table name
     * @return object
     */
    public function read(string $table): object;

    /**
     * SELECT DISTINCT
     * 
     * @param string $table table name
     * @return object
     */
    public function readDistinct(string $table): object;

    /**
     * Update
     * 
     * @param string $table table name
     * @return object
     */
    public function update(string $table): object;

    /**
     * Delete
     * 
     * @param string $table table name
     * @return object
     */
    public function delete(string $table): object;

    /**
     * Drop
     * 
     * @param string $table table name
     * @return object
     */
    public function drop(string $table): object;

    /**
     * Set Column
     * 
     * @param string $identificator Column Identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function set(string $identificator, mixed $value): object;

    /**
     * WHERE operator
     * 
     * @param string $identificator WHERE identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function where(string $identificator, mixed $value): object;

    /**
     * AND operator
     * 
     * @param string $identificator AND identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function and(string $identificator, mixed $value): object;

    /**
     * OR operator
     * 
     * @param string $identificator OR identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function or(string $identificator, mixed $value): object;

    /**
     * LEFT JOIN (LEFT JOIN operator)
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function leftJoin(string $identificator): object;

    /**
     * ON operator
     * 
     * @param string $identificator ON identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function on(string $identificator, mixed $value): object;

    /**
     * USING (USING operator)
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function using(string $identificator): object;

    /**
     * AS (AS operator)
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function as(string $identificator): object;

    /**
     * GROUP BY identificator
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function groupBy(string $identificator): object;

    /**
     * ORDER BY identificator
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderBy(string $identificator): object;

    /**
     * ORDER BY identificator DESC
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderByDesc(string $identificator): object;

    /**
     * ORDER BY identificator ASC
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderByAsc(string $identificator): object;

    /**
     * LIMIT (LIMIT 10, 2 and etc)
     * 
     * @param mixed $offset offset value
     * @param mixed $limit limit value
     * @return object
     */
    public function limit(mixed $offset, mixed $limit): object;

    /**
     * Any operator
     * 
     * @param string $operator Any operator
     * @param string $identificator Any identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function operator(string $operator, string $identificator, mixed $value): object;

    /**
     * Get associated array 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectAssoc(string $identificator): object;

    /**
     * Get an indexed array 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectIndex(string $identificator): object;

    /**
     * Get value
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectValue(string $identificator): object;

    /**
     * Get object
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectObj(string $identificator): object;

    /**
     * Count the number of columns 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectColCount(string $identificator): object;

    /**
     * Count the number of rows 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectRowCount(string $identificator): object;

    /**
     * Last Insert Id
     * 
     * @return object
     */
    public function lastInsertId(): object;

    /**
     * Save
     * 
     * @return mixed
     */
    public function save(): mixed;

    /**
     * Install DB-file
     *
     * @param string $path Path to DB file
     * @param string $db_prefix Prefix in the database to be replaced with the one set
     * @return mixed
     */
    public function dbInstall(string $path, string $db_prefix = 'emkt_'): mixed;

    /**
     * PDO exec()
     *
     * @param string $data SQL data
     * @return mixed
     */
    public function exec(string $data): mixed;
}
