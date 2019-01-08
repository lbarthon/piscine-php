#!/usr/bin/php
<?php
    function ft_print_array(array $array) {
        foreach ($array as $value) {
            print($value . "\n");
        }
    }

    function is_alpha($str) {
        $array = str_split($str);
        foreach ($array as $char) {
            $i = ord($char);
            if (!(($i >= 65 && $i <= 90) || ($i >= 97 && $i <= 122))) {
                return false;
            }
        }
        return true;
    }

    function filter($var) {
        return ($var !== "" && $var !== null && $var !== false);
    }

    $i = 1;
    $array = null;
    while ($i < $argc) {
        $array = $array !== null ? 
            array_merge($array, explode(" ", $argv[$i])) : explode(" ", $argv[$i]);
        $i++;
    }
    if ($array !== null) {
        $array = array_filter($array, 'filter');
        $nbrs = array();
        $strs = array();
        $others = array();
        foreach ($array as $value) {
            if (is_numeric($value) === true) {
                $nbrs[] = $value;
            } else if (is_alpha($value) === true) {
                $strs[] = $value;
            } else {
                $others[] = $value;
            }
        }
        sort($strs, SORT_NATURAL | SORT_FLAG_CASE);
        sort($nbrs, SORT_STRING);
        sort($others);
        ft_print_array($strs);
        ft_print_array($nbrs);
        ft_print_array($others);
    }
