<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder\Sqlite;

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
    #[\Override]
    public function pattern($func, $data = ''): mixed {

        //$quotes = "'";
        $functions = [
            'YEAR' => 'strftime("%Y",' . $data . ')',
            'MONTH' => 'strftime("%m",' . $data . ')',
            'DAYOFWEEK' => 'strftime("%w",' . $data . ')',
            'DAY' => 'strftime("%d",' . $data . ')',
            'DAYOFYEAR' => 'strftime("%j",' . $data . ')',
            'QUARTER' => '(strftime("%m",' . $data . ') + 2) / 3 AS QUARTER',
            'HOUR' => 'strftime("%H",' . $data . ')',
            'UNIX_TIMESTAMP' => 'unixepoch(' . $data . ')',
            'LIKE' => 'LIKE ',
            'CAST AS CHAR' => 'CAST(' . $data . ' AS CHAR)',
            'MIN' => 'MIN(' . $data . ')',
            'MAX' => 'MAX(' . $data . ')',
            'COUNT' => 'COUNT(' . $data . ')',
        ];

        return $functions[$func];
    }

}
