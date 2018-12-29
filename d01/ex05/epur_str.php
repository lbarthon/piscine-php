#!/usr/bin/php
<?php
    if ($argc >= 2) {
        $array = explode(" ", $argv[1]);
    }
    if ($array) {
        $array = array_filter($array);
        $i = sizeof($array);
        $nbr = 1;
        foreach ($array as $word) {
            print($word);
            if ($nbr != $i) print(" ");
            else print("\n");
            $nbr++;
        }
    }
?>