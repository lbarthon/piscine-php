#!/usr/bin/php
<?php
    if ($argc != 2 ) {
        die("Incorrect Parameters\n");
    }
    
    $chars = str_split(trim($argv[1]));
    
    $nbr1 = 0;
    $sign1 = 1;
    $op = null;
    $nbr2 = 0;
    $sign2 = 1;
    $index = 0;
    $nbrset = 0;

    if ($chars[$index] === "+" || $chars[$index] === "-") {
        $sign1 = $chars[$index] === "-" ? -1 : 1;
        $index++;
    }
    while (is_numeric($chars[$index]) === true) {
        $nbr1 *= 10;
        $nbr1 += $chars[$index++];
        $nbrset = 1;
    }
    while ($chars[$index] === " ") {
        $index++;
    }
    if ($nbrset === 1) {
        $op = $chars[$index++];
    }
    $nbrset = 0;
    while ($chars[$index] === " ") {
        $index++;
    }
    if ($chars[$index] === "+" || $chars[$index] === "-") {
        $sign2 = $chars[$index] === "-" ? -1 : 1;
        $index++;
    }
    while (is_numeric($chars[$index]) === true) {
        $nbr2 *= 10;
        $nbr2 += $chars[$index++];
        $nbrset = 1;
    }
    
    $nbr1 *= $sign1;
    $nbr2 *= $sign2;

    if ($nbrset === 0) {
        die("Syntax Error\n");
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
