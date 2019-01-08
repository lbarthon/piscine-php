#!/usr/bin/php
<?php
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
        sort($array, SORT_STRING);
        foreach ($array as $word) {
            print($word . "\n");
        }
    }
