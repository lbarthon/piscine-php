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
        $i = sizeof($array);
        $nbr = 1;
        foreach ($array as $word) {
            print($word);
            if ($nbr != $i) print(" ");
            else print("\n");
            $nbr++;
        }
    }
