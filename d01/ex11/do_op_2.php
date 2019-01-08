#!/usr/bin/php
<?php
    if ($argc != 2 ) {
        die("Incorrect Parameters\n");
    }
    
    $chars = str_split(trim($argv[1]));
    
    $nbr1 = 0;
    $op = null;
    $nbr2 = 0;
    $index = 0;
    
    while (is_numeric($chars[$index]) === true) {
        $nbr1 *= 10;
        $nbr1 += $chars[$index++];
    }
    while ($chars[$index] === " ") {
        $index++;
    }
    $op = $chars[$index++];
    while ($chars[$index] === " ") {
        $index++;
    }
    while (is_numeric($chars[$index]) === true) {
        $nbr2 *= 10;
        $nbr2 += $chars[$index++];
    }
    
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
    } else {
        die("Syntax Error\n");
    }
