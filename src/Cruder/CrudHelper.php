<?php

/* =-=-=-= Copyright © 2023 Cruder =-=-=-=-=- 
  |           APACHE-2.0 LICENSE            |
  |   https://github.com/musicman3/Cruder   |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace Cruder;

/**
 * Crud Helper
 *
 * @package Core
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license APACHE-2.0 LICENSE
 * 
 */
class CrudHelper {

    /**
     * Request Normalization (removing extra spaces)
     *
     * @param string|int $str Input string
     * @return output string
     */
    protected function requestNormalization(string|int $str): string {
        $output = implode(' ', array_filter(explode(' ', $str)));
        return $output;
    }

    /**
     * Output Data Normalization (removing empty values)
     * 
     * @param mixed $array Input array
     * @return mixed
     */
    protected function outputNormalization(mixed $array): mixed {
        if (isset($array) && is_array($array)) {
            $result = array_filter($array, function ($data) {
                return $data !== '';
            });
            $output = array_values($result);
            return $output;
        }
        return FALSE;
    }

}
