<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder\Postgres;

use Cruder\{
    DbFunctionsInterface
};

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

    /**
     * Pattern
     * 
     * @param string $func DB Function name
     * @param string $data DB Function data
     * @return mixed
     */
    public function pattern($func, $data = ''): mixed {

        //$quotes = "'";
        $functions = [
            'YEAR' => 'EXTRACT(YEAR FROM ' . $data . ')',
            'MONTH' => 'EXTRACT(MONTH FROM ' . $data . ')',
            'DAYOFWEEK' => 'EXTRACT(DOW FROM ' . $data . ')',
            'DAY' => 'EXTRACT(DAY FROM ' . $data . ')',
            'DAYOFYEAR' => 'EXTRACT(DOY FROM ' . $data . ')',
            'QUARTER' => 'EXTRACT(QUARTER FROM ' . $data . ')',
            'HOUR' => 'EXTRACT(HOUR FROM ' . $data . ')',
            'UNIX_TIMESTAMP' => 'EXTRACT(EPOCH FROM ' . $data . ')',
            'LIKE' => 'ILIKE ',
            'CAST AS CHAR' => 'CAST(' . $data . ' AS CHAR)',
            'TIMESTAMP' => 'TIMESTAMP(' . $data . ')',
            'TIME' => 'TIME(' . $data . ')',
            'DEFAULT' => 'DEFAULT(' . $data . ')',
            'MIN' => 'MIN(' . $data . ')',
            'MAX' => 'MAX(' . $data . ')',
            'RLIKE' => 'SIMILAR TO ',
            'IN' => 'IN(' . $data . ')',
            'NOT' => 'NOT',
            'BETWEEN' => 'BETWEEN',
            'REGEXP' => 'REGEXP',
            'IS NULL' => 'IS NULL',
            'IS NOT NULL' => 'IS NOT NULL',
            'VERSION' => 'VERSION(' . $data . ')',
            'LAST_INSERT_ID' => 'LAST_INSERT_ID(' . $data . ')',
            'JSON_SEARCH' => 'JSON_SEARCH(' . $data . ')',
            'JSON_SET' => 'JSON_SET(' . $data . ')',
            'JSON_REPLACE' => 'JSON_REPLACE(' . $data . ')',
            'JSON_REMOVE' => 'JSON_REMOVE(' . $data . ')',
            'JSON_EXTRACT' => 'JSON_EXTRACT(' . $data . ')',
            'JSON_ARRAY' => 'JSON_ARRAY(' . $data . ')',
            'JSON_ARRAY_APPEND' => 'JSON_ARRAY_APPEND(' . $data . ')',
            'JSON_ARRAY_INSERT' => 'JSON_ARRAY_INSERT(' . $data . ')',
            'JSON_OBJECT' => 'JSON_OBJECT(' . $data . ')'
        ];

        return $functions[$func];
    }

}
