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
     * @param string $limit limit text
     * @return object
     */
    public function limit(string $limit): object;

    /**
     * Any operator
     * 
     * @param string $operator Any operator
     * @param string $identificator OR identificator
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
    public function selectGetAssoc(string $identificator): object;

    /**
     * Get an indexed array 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectGetIndex(string $identificator): object;

    /**
     * Get value
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectGetValue(string $identificator): object;

    /**
     * Get object
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectGetObj(string $identificator): object;

    /**
     * Count the number of columns 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectGetColCount(string $identificator): object;

    /**
     * Count the number of rows 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectGetRowCount(string $identificator): object;

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
     * @param string $path Path to DB
     * @param string $db_prefix Prefix in the database to be replaced with the one set
     * @return mixed
     */
    public static function dbInstall(string $path, string $db_prefix = 'emkt_'): mixed;
}
