#!/usr/bin/php
<?php
    function ft_print_array(array $array) {
        foreach ($array as $value) {
            print($value . "\n");
        }
    }

    $i = 1;
    while ($i < $argc) {
        $array = $array ? array_merge($array, explode(" ", $argv[$i])) : explode(" ", $argv[$i]);
        $i++;
    }
    $array = array_filter($array);
    if ($array) {
        foreach ($array as $value) {
            if (is_numeric($value)) {
                $nbrs[] = $value;
            } else if (ctype_alpha($value)) {
                $strs[] = $value;
            } else {
                $others[] = $value;
            }
        }
        sort($strs, SORT_NATURAL | SORT_FLAG_CASE);
        sort($nbrs, SORT_STRING);
        sort($others);
        ft_print_array($strs);
        ft_print_array($nbrs);
        ft_print_array($others);
    }
?>