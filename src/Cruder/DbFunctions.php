<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder;

/**
 * DbFunctions
 *
 * @package Cruder
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license Apache-2.0
 * 
 */
class DbFunctions implements DbFunctionsInterface {

    private $db_func;

    /**
     * Constructor
     *
     */
    function __construct() {
        if (Pdo::$set['db_type'] == 'mysql') {
            $this->db_func = new Mysql\DbFunctions();
        }
        if (Pdo::$set['db_type'] == 'pgsql') {
            $this->db_func = new Postgres\DbFunctions();
        }
        if (Pdo::$set['db_type'] == 'sqlite') {
            $this->db_func = new Sqlite\DbFunctions();
        }
    }

    /**
     * Pattern
     * 
     * @param string $func DB Function name
     * @param string $data DB Function data
     * @return mixed
     */
    #[\Override]
    public function pattern($func, $data = ''): mixed {
        return $this->db_func->pattern($func, $data);
    }

}
