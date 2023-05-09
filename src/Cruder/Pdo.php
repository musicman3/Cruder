<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder;

/**
 * PDO
 *
 * @package Cruder
 * @author Cruder Team & eMarket Team
 * @copyright © 2023 Cruder
 * @license Apache-2.0
 * 
 */
class Pdo {

    public static $query_count = 0;
    private static $connect = null;

    /** DB Settings

     * EXAMPLE:

      $set = [
      'db_type' => 'mysql',
      'db_server' => 'localhost',
      'db_name' => 'my_db',
      'db_username' => 'root',
      'db_password' => 'pass',
      'db_prefix' => 'emkt_',
      'db_port' => '3306',
      'db_family' => 'myisam',
      'db_charset' => 'utf8mb4',
      'db_collate' => 'utf8mb4_unicode_ci',
      'db_error_url' => '/my_error_page/?error_message=',
      'db_path' => '/my_db_path/sqlite.db'
      ];

     */
    public static $set;

    /**
     * Conecting to DB
     * @param string $status Marker
     * @return mixed PDO object or error message
     */
    public static function connect(?string $status = null): mixed {

        self::$query_count++;

        if ($status == 'close') {
            self::$connect = null;
            return self::$connect;
        }

        $host = ':host=' . self::$set['db_server'] . ';';

        if (isset(self::$set['db_name'])) {
            $host = ':host=' . self::$set['db_server'] . ';dbname=' . self::$set['db_name'];
        }

        if (self::$connect == null) {

            try {
                if (self::$set['db_type'] == 'mysql') {
                    self::$connect = new \PDO(self::$set['db_type'] . $host, self::$set['db_username'], self::$set['db_password'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . self::$set['db_charset'] . " COLLATE " . self::$set['db_collate']]);
                }
                if (self::$set['db_type'] == 'pgsql') {
                    self::$connect = new \PDO(self::$set['db_type'] . $host, self::$set['db_username'], self::$set['db_password'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
                }
                if (self::$set['db_type'] == 'sqlite') {
                    self::$connect = new \PDO(self::$set['db_type'] . ':' . self::$set['db_path'], self::$set['db_username'], self::$set['db_password'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
                }
            } catch (\PDOException $error) {
                if (isset(self::$set['db_error_url'])) {
                    header('Location: ' . self::$set['db_error_url'] . $error->getMessage());
                }
            }
        }

        return self::$connect;
    }

    /**
     * getExec instead self::connect()->exec()
     *
     * @param string $sql SQL query
     * @return mixed data
     */
    public static function getExec(string $sql): mixed {

        $result = self::connect()->exec($sql);
        return $result;
    }

    /**
     * Get value
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getValue(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchColumn();
        }
        return CrudHelper::outputDataFiltering($result);
    }

    /**
     * Get an indexed array 
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getIndex(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_NUM);
        }
        return CrudHelper::outputDataFiltering($result);
    }

    /**
     * Get associated array 
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getAssoc(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_ASSOC);
        }
        return CrudHelper::outputDataFiltering($result);
    }

    /**
     * Get object
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getObj(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_OBJ);
        }
        return $result;
    }

    /**
     * Count the number of columns 
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getColCount(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->ColumnCount();
        }
        return $result;
    }

    /**
     * Count the number of rows 
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getRowCount(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->RowCount();
        }
        return $result;
    }

    /**
     * Action (INSERT INTO, DELETE and UPDATE)
     *
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function action(string $sql, ?array $param = null): mixed {

        $exec = self::connect()->prepare($sql);
        $exec->execute($param);

        return $exec;
    }

    /**
     * lastInsertId
     * 
     * @return int|string
     */
    public static function lastInsertId(): int|string {

        $result = self::connect()->lastInsertId();
        return $result;
    }

}
