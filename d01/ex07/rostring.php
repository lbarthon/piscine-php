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
        $size = count($array);
        $i = 1;
        while ($i < $size) {
            echo $array[$i] . " ";
            $i++;
        }
        echo $array[0] . "\n";
    }
