<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder\Mysql;

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
            'YEAR' => 'YEAR(' . $data . ')',
            'MONTH' => 'MONTH(' . $data . ')',
            'DAYOFWEEK' => 'DAYOFWEEK(' . $data . ')',
            'DAY' => 'DAY(' . $data . ')',
            'DAYOFYEAR' => 'DAYOFYEAR(' . $data . ')',
            'QUARTER' => 'QUARTER(' . $data . ')',
            'HOUR' => 'HOUR(' . $data . ')',
            'DEFAULT' => 'DEFAULT(' . $data . ')',
            'MIN' => 'MIN(' . $data . ')',
            'MAX' => 'MAX(' . $data . ')',
            'RLIKE' => 'RLIKE',
            'LIKE' => 'LIKE',
            'TIMESTAMP' => 'TIMESTAMP(' . $data . ')',
            'UNIX_TIMESTAMP' => 'UNIX_TIMESTAMP(' . $data . ')',
            'TIME' => 'TIME(' . $data . ')',
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
            'JSON_OBJECT' => 'JSON_OBJECT(' . $data . ')',
        ];

        return $functions[$func];
    }

}
