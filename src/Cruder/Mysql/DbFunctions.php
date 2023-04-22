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
            'QUARTER' => 'QUARTER(' . $data . ')',
            'MIN' => 'MIN(' . $data . ')'
        ];

        return $functions[$func];
    }

}