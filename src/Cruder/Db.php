<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder;

use Cruder\Pdo;

/**
 * CRUD DB Options
 *
 * @package Cruder 
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license Apache-2.0
 * 
 */
class Db {

    public static $db = false;

    /**
     * PDO Set

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
     * 
     * @param array $data Settings data
     */
    public static function set(array $data): void {

        Pdo::$set = $data;
    }

    /**
     * DB Connect
     * 
     * @return object
     */
    public static function connect(): Cruder {

        if (!self::$db) {
            self::$db = new Cruder();
        }
        return self::$db;
    }

    /**
     * PDO Close connect
     * 
     */
    public static function close(): void {

        Pdo::connect('close');
    }

}
