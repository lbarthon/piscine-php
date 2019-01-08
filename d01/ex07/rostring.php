#!/usr/bin/php
<?php
    function filter($var) {
        return ($var !== "" && $var !== null && $var !== false);
    }

    $array = null;
    if ($argc >= 2) {
        $array = explode(" ", $argv[1]);
    }
    if ($array !== null) {
        $array = array_filter($array, 'filter');
        $array = array_reverse($array);
        $i = sizeof($array);
        foreach ($array as $word) {
            print($word);
            $i--;
            if ($i != 0) print(" ");
            else print("\n");
        }
    }
