#!/usr/bin/php
<?php
    $array = null;
    if ($argc >= 2) {
        $array = explode(" ", $argv[1]);
    }
    if ($array !== null) {
        $array = array_filter($array);
        $array = array_reverse($array);
        $i = sizeof($array);
        foreach ($array as $word) {
            print($word);
            $i--;
            if ($i != 0) print(" ");
            else print("\n");
        }
    }
