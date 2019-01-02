#!/usr/bin/php
<?php
    $i = 1;
    $array = null;
    while ($i < $argc) {
        $array = $array ? array_merge($array, explode(" ", $argv[$i])) : explode(" ", $argv[$i]);
        $i++;
    }
    if ($array !== null) {
        $array = array_filter($array);
        sort($array);
        foreach ($array as $word) {
            print($word . "\n");
        }
    }

