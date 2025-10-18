<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder;

use Cruder\{
    Pdo,
    DbFunctions
};

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

    public static $db_functions = false;
    public static $config;

    /**
     * DB config
     * 
     * @param array $data Settings data
     */
    public static function config(array $data): void {
        self::$config = $data;
    }

    /**
     * Use the selected database
     * 
     * @param string $db Db Config name
     * @return object
     */
    public static function use(string $db): object {

        self::close();

        if (isset(self::$config[$db])) {
            Pdo::$set = self::$config[$db];
        }
        Pdo::$connect = null;

        return new static;
    }

    /**
     * Get settings
     * 
     * @return array|null
     */
    public static function get(): array|null {
        return self::$config;
    }

    /**
     * Transactions on/off
     * 
     * @param string $switch Transactions on/off
     */
    public static function transactions(string $switch): void {

        if ($switch == 'on') {
            Pdo::connect('close');
            Pdo::$connect = null;
            Pdo::$set['db_transactions'] = 'true';
        }
        if ($switch == 'off') {
            if (Pdo::connect()->inTransaction() == true) {
                Pdo::connect()->commit();
            }
            Pdo::connect('close');
            Pdo::$connect = null;
            Pdo::$set['db_transactions'] = 'false';
        }

        if (isset(Pdo::$set['db_transactions']) && Pdo::$set['db_transactions'] == 'true' && Pdo::$set['db_family'] != 'myisam') {
            Pdo::connect()->beginTransaction();
        }
    }

    /**
     * DB Connect
     * 
     * @return object
     */
    public static function connect(): Cruder {
        return new Cruder();
    }

    /**
     * PDO Close connect
     * 
     */
    public static function close(): void {

        if (isset(Pdo::$set['db_transactions']) && Pdo::$set['db_transactions'] == 'true' && Pdo::$set['db_family'] != 'myisam' && Pdo::connect()->inTransaction() == true) {
            Pdo::connect()->commit();
        }
        Pdo::connect('close');
    }

    /**
     * DB Functions pattern
     * 
     * @param string $func DB Function name
     * @param string $data DB Function data
     * @return mixed
     */
    public static function functions($func, $data = ''): mixed {

        if (!self::$db_functions) {
            self::$db_functions = new DbFunctions();
        }
        return self::$db_functions->pattern($func, $data);
    }
}
