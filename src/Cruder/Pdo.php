<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder;

use eMarket\Core\{
    Func,
    Settings
};

/**
 * PDO
 *
 * @package Core
 * @author Cruder Team & eMarket Team
 * @copyright © 2023 Cruder
 * @license APACHE-2.0 LICENSE
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
      'db_family' => 'myisam'
      ];

     */
    public static $set;

    /**
     * Conecting to DB
     * @param string $status Marker
     * @return object PDO object
     */
    public static function connect(?string $status = null): ?object {

        self::$query_count++;

        if ($status == 'close') {
            self::$connect = null;
            return self::$connect;
        }

        if (self::$connect == null && isset(self::$set['db_type'], self::$set['db_server'], self::$set['db_name'], self::$set['db_username'], self::$set['db_password'])) {

            try {
                self::$connect = new \PDO(self::$set['db_type'] . ':host=' . self::$set['db_server'] . ';dbname=' . self::$set['db_name'], self::$set['db_username'], self::$set['db_password'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"]);
            } catch (\PDOException $error) {
                if (Settings::path() == 'install') {
                    header('Location: /controller/install/error.php?server_db_error=true&error_message=' . $error->getMessage());
                    exit;
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
        return Func::outputDataFiltering($result);
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
        return Func::outputDataFiltering($result);
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
        return Func::outputDataFiltering($result);
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
