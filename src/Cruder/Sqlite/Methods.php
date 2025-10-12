<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder\Sqlite;

use Cruder\{
    CrudInterface,
    CrudHelper,
    Pdo
};

/**
 * Mysql Methods
 *
 * @package Cruder
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license Apache-2.0
 * 
 */
class Methods extends CrudHelper implements CrudInterface {

    protected $insert;
    protected $values;

    /**
     * Create
     * 
     * @param string $table table name
     * @return object
     */
    public function create(string $table): object {
        $this->action = 'create';
        $this->table = $table;
        return $this;
    }

    /**
     * Read
     * 
     * @param string $table table name
     * @return object
     */
    public function read(string $table): object {
        $this->table = $table;
        return $this;
    }

    /**
     * SELECT DISTINCT
     * 
     * @param string $table table name
     * @return object
     */
    public function readDistinct(string $table): object {
        $this->action = 'readDistinct';
        $this->table = $table;
        return $this;
    }

    /**
     * Update
     * 
     * @param string $table table name
     * @return object
     */
    public function update(string $table): object {
        $this->action = 'update';
        $this->table = $table;
        return $this;
    }

    /**
     * Delete
     * 
     * @param string $table table name
     * @return object
     */
    public function delete(string $table): object {
        $this->action = 'delete';
        $this->table = $table;
        return $this;
    }

    /**
     * Drop
     * 
     * @param string $table table name
     * @return object
     */
    public function drop(string $table): object {
        $this->action = 'drop';
        $this->table = $table;
        return $this;
    }

    /**
     * Set Column
     * 
     * @param string $identificator Column Identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function set(string $identificator, mixed $value): object {
        if ($value === false || $value === '') {
            $value = null;
        }
        $this->set .= $identificator . '=?, ';
        $this->insert .= $identificator . ', ';
        $this->values .= '?, ';
        $this->crud[] = $value;

        return $this;
    }

    /**
     * WHERE operator
     * 
     * @param string $identificator WHERE identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function where(string $identificator, mixed $value): object {
        if ($value === false || $value === '') {
            $value = null;
        }
        $this->method_chain .= 'WHERE ' . $identificator . '? ';
        $this->crud[] = $value;

        return $this;
    }

    /**
     * AND operator
     * 
     * @param string $identificator AND identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function and(string $identificator, mixed $value): object {
        if ($value === false || $value === '') {
            $value = null;
        }
        $this->method_chain .= 'AND ' . $identificator . '? ';
        $this->crud[] = $value;

        return $this;
    }

    /**
     * OR operator
     * 
     * @param string $identificator OR identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function or(string $identificator, mixed $value): object {
        if ($value === false || $value === '') {
            $value = null;
        }
        $this->method_chain .= 'OR ' . $identificator . '? ';
        $this->crud[] = $value;

        return $this;
    }

    /**
     * LEFT JOIN identificator
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function leftJoin(string $identificator): object {
        $this->method_chain .= 'LEFT JOIN ' . $identificator . ' ';
        return $this;
    }

    /**
     * ON operator
     * 
     * @param string $identificator ON identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function on(string $identificator, mixed $value): object {
        if ($value === false || $value === '') {
            $value = null;
        }
        $this->method_chain .= 'ON (' . $identificator . $value . ')';

        return $this;
    }

    /**
     * AS (AS operator)
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function as(string $identificator): object {
        $this->method_chain .= 'AS ' . $identificator . ' ';
        return $this;
    }

    /**
     * GROUP BY identificator
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function groupBy(string $identificator): object {
        $this->method_chain .= 'GROUP BY ' . $identificator . ' ';
        return $this;
    }

    /**
     * ORDER BY identificator
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderBy(string $identificator): object {
        $this->method_chain .= 'ORDER BY ' . $identificator . ' ';
        return $this;
    }

    /**
     * ORDER BY identificator DESC
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderByDesc(string $identificator): object {
        $this->method_chain .= 'ORDER BY ' . $identificator . ' DESC ';
        return $this;
    }

    /**
     * ORDER BY identificator ASC
     * 
     * @param string $identificator identificator
     * @return object
     */
    public function orderByAsc(string $identificator): object {
        $this->method_chain .= 'ORDER BY ' . $identificator . ' ASC ';
        return $this;
    }

    /**
     * LIMIT (LIMIT 10, 2 and etc)
     * 
     * @param mixed $offset offset value
     * @param mixed $limit limit value
     * @return object
     */
    public function limit(mixed $offset, mixed $limit = null): object {
        if ($limit === '' || $limit === null) {
            $this->method_chain .= 'LIMIT ' . $offset . ' ';
        } else {
            $this->method_chain .= 'LIMIT ' . $offset . ',' . $limit . ' ';
        }
        return $this;
    }

    /**
     * Any operator
     * 
     * @param string $operator Any operator
     * @param string $identificator Any identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function operator(string $operator, string $identificator = '', mixed $value = ''): object {
        if ($value === false || $value === '') {
            $value = null;
        }

        $sign = '? ';

        if ($identificator == '') {
            $sign = '';
        }

        $this->method_chain .= $operator . ' ' . $identificator . $sign;
        $this->crud[] = $value;

        return $this;
    }

    /**
     * Get associated array 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectAssoc(string $identificator): object {
        $this->crud[$identificator] = '';
        $this->action = 'getAssoc';
        return $this;
    }

    /**
     * Get an indexed array 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectIndex(string $identificator): object {
        $this->crud[$identificator] = '';
        $this->action = 'getIndex';
        return $this;
    }

    /**
     * Get value
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectValue(string $identificator): object {
        $this->crud[$identificator] = '';
        $this->action = 'getValue';
        return $this;
    }

    /**
     * Get object
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectObj(string $identificator): object {
        $this->crud[$identificator] = '';
        $this->action = 'getObj';
        return $this;
    }

    /**
     * Count the number of columns 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectColCount(string $identificator): object {
        $this->crud[$identificator] = '';
        $this->action = 'getColCount';
        return $this;
    }

    /**
     * Count the number of rows 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectRowCount(string $identificator): object {
        $this->crud[$identificator] = '';
        $this->action = 'getRowCount';
        return $this;
    }

    /**
     * Last Insert Id
     * 
     * @return object
     */
    public function lastInsertId(): object {
        $this->action = 'lastInsertId';
        return $this;
    }

    /**
     * Save
     * 
     * @return mixed
     */
    public function save(): mixed {
        if ($this->action == 'create') {
            return $this->finalData('INSERT INTO ' . $this->table . ' (' . rtrim($this->insert, ', ') . ') VALUES (' . rtrim($this->values, ', ') . ') ');
        }
        if ($this->action == 'update') {
            return $this->finalData('UPDATE ' . $this->table . ' SET ' . $this->set);
        }
        if ($this->action == 'delete') {
            return $this->finalData('DELETE FROM ' . $this->table . ' ');
        }
        if ($this->action == 'drop') {
            return $this->finalData('DROP TABLE ' . $this->table . ' ');
        }
        if ($this->action == 'readDistinct') {
            return $this->finalData('SELECT DISTINCT ');
        }
        return $this->finalData('SELECT ');
    }

    /**
     * Install DB-file
     *
     * @param string $path Path to DB file
     * @param string $db_prefix Prefix in the database to be replaced with the one set
     * @return mixed
     */
    public function dbInstall(string $path, string $db_prefix = 'emkt_'): mixed {

        $set = Pdo::$set;

        $buffer = str_replace($db_prefix, $set['db_prefix'], implode(file($path)));

        Pdo::getExec($buffer);

        return true;
    }

    /**
     * PDO exec()
     *
     * @param string $data SQL data
     * @return mixed
     */
    public function exec(string $data): mixed {

        Pdo::getExec($data);

        return true;
    }
}
