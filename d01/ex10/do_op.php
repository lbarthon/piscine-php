#!/usr/bin/php
<?php
    if ($argc !== 4) {
        print("Incorrect Parameters\n");
    } else {
        $nbr1 = trim($argv[1]);
        $op = trim($argv[2]);
        $nbr2 = trim($argv[3]);
        if ($op === "+") {
            echo $nbr1 + $nbr2 . "\n";
        } else if ($op === "-") {
            echo $nbr1 - $nbr2 . "\n";
        } else if ($op === "*") {
            echo $nbr1 * $nbr2 . "\n";
        } else if ($op === "/") {
            echo $nbr1 / $nbr2 . "\n";
        } else if ($op === "%") {
            echo $nbr1 % $nbr2 . "\n";
        }
    }
