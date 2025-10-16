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
    #[\Override]
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
            'MIN' => 'MIN(' . $data . ')',
            'MAX' => 'MAX(' . $data . ')',
            'COUNT' => 'COUNT(' . $data . ')',
        ];

        return $functions[$func];
    }

}
