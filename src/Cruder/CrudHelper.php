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
 * @package Cruder
 * @author Cruder Team
 * @copyright © 2023 Cruder
 * @license Apache-2.0
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
        $prepare = implode(' ', array_filter(explode(' ', $str)));
        $output = $this->originalSyntax($prepare);
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

    /**
     * Original DB syntax
     * Example for MySQL:
     * Input: email, order_total, {DAYOFWEEK->date_purchased}
     * Output: email, order_total, DAYOFWEEK(date_purchased)
     * 
     * @param string $input Input SQL not-formating string
     */
    private function originalSyntax(string $input): mixed {

        $DbPattern = new DbFunctions();

        preg_match_all('|{{(.*)}}|isU', $input, $data);

        $func = [];
        foreach ($data[1] as $value) {
            $explode_data = explode('->', $value);
            if (!isset($explode_data[1])) {
                $explode_data[1] = '';
            }
            $func[] = $DbPattern->pattern($explode_data[0], $explode_data[1]);
        }

        $output = str_replace($data[0], $func, $input);

        return $output;
    }

    /**
     * Function for escaping special characters.
     * Output data filtering 
     *
     * @param string|array $data Data to escape characters
     * @return mixed
     */
    public static function outputDataFiltering(mixed $data): mixed {
        // symbol and replacement
        $find = ["'", "script", "/.", "./"];
        $replace = ["&#8216;", "!s-c-r-i-p-t!", "!/.!", "!./!"];

        $output = self::recursiveArrayReplace($find, $replace, $data);

        return $output;
    }

    /**
     * Recursive array replace
     *
     * @param string|array $find Find value
     * @param string|array $replace Replace value
     * @param string|array $data Input data
     * @return mixed
     */
    public static function recursiveArrayReplace(array|string $find, array|string $replace, mixed $data): mixed {
        if (is_bool($data) || is_null($data)) {
            return $data;
        }

        if (is_int($data)) {
            return str_ireplace($find, $replace, (string) $data);
        }

        if (!is_array($data)) {
            return str_ireplace($find, $replace, (string) $data);
        }

        $output = [];
        foreach ($data as $key => $value) {
            $output[$key] = self::recursiveArrayReplace($find, $replace, $value);
        }
        return $output;
    }

}
