<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder\Mysql;

use Cruder\{
    CrudInterface,
    CrudHelper,
    Pdo
};

/**
 * CRUD Mysql Adapter
 *
 * @package Cruder
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license APACHE-2.0 LICENSE
 * 
 */
class Methods extends CrudHelper implements CrudInterface {

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
     * Set Column
     * 
     * @param string $identificator Column Identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function set(string $identificator, mixed $value): object {
        $this->set .= $identificator . '=?, ';
        $this->crud[] = (string) $value;
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
        $this->method_chain .= 'WHERE ' . $identificator . '? ';
        $this->crud[] = (string) $value;
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
        $this->method_chain .= 'AND ' . $identificator . '? ';
        $this->crud[] = (string) $value;
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
        $this->method_chain .= 'OR ' . $identificator . '? ';
        $this->crud[] = (string) $value;
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
     * @param string $limit limit text
     * @return object
     */
    public function limit(string $limit): object {
        $this->method_chain .= 'LIMIT ' . $limit . ' ';
        return $this;
    }

    /**
     * Any operator
     * 
     * @param string $operator Any operator
     * @param string $identificator OR identificator
     * @param mixed $value Identificator Value
     * @return object
     */
    public function operator(string $operator, string $identificator = '', mixed $value = ''): object {

        $sign = '? ';

        if ($identificator == '') {
            $sign = '';
        }

        $this->method_chain .= $operator . ' ' . $identificator . $sign;
        $this->crud[] = (string) $value;
        return $this;
    }

    /**
     * Get associated array 
     * 
     * @param string $identificator SELECT identificators
     * @return object
     */
    public function selectGetAssoc(string $identificator): object {
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
    public function selectGetIndex(string $identificator): object {
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
    public function selectGetValue(string $identificator): object {
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
    public function selectGetObj(string $identificator): object {
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
    public function selectGetColCount(string $identificator): object {
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
    public function selectGetRowCount(string $identificator): object {
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
            return $this->finalData('INSERT INTO ' . $this->table . ' SET ' . $this->set);
        }
        if ($this->action == 'update') {
            return $this->finalData('UPDATE ' . $this->table . ' SET ' . $this->set);
        }
        if ($this->action == 'delete') {
            return $this->finalData('DELETE FROM ' . $this->table . ' ');
        }
        return $this->finalData('SELECT ');
    }

    /**
     * Install DB-file
     *
     * @param string $path Path to DB
     * @param string $db_prefix Prefix in the database to be replaced with the one set
     * @return mixed
     */
    public static function dbInstall(string $path, string $db_prefix = 'emkt_'): mixed {

        $set = Pdo::$set;

        $file_name = $path . $set['db_type'] . '.sql';

        $buffer = str_replace($db_prefix, $set['db_prefix'], implode(file($file_name)));

        if ($set['db_family'] == 'myisam') {
            $buffer = str_ireplace('ENGINE=InnoDB', 'ENGINE=MyISAM', $buffer);
        }

        Pdo::getExec($buffer);

        return true;
    }

}
