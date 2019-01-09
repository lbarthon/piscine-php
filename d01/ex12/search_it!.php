#!/usr/bin/php
<?php
    function ft_strlen($str) {
        return $str !== null ? count(str_split($str)) : 0;
    }

    function starts_with ($string, $start) 
    {
        $len = ft_strlen($start); 
        return (substr($string, 0, $len) === $start); 
    }
    if ($argc > 2) {
        $key = $argv[1];
        $i = 2;
        $message = null;
        while ($i < $argc) {
            if (starts_with($argv[$i], $key)) {
                $message = substr($argv[$i], ft_strlen($key) + 1) . "\n";
            }
            $i++;
        }
        if ($message !== null) {
            echo $message;
        }
    }

