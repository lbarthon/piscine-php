#!/usr/bin/php
<?php
    function starts_with ($string, $start) 
    { 
        $len = strlen($start); 
        return (substr($string, 0, $len) === $start); 
    }

    if ($argc > 2) {
        $key = $argv[1];
        $i = 2;
        $message = null;
        while ($i < $argc) {
            if (starts_with($argv[$i], $key)) {
                $message = substr($argv[$i], strlen($key) + 1) . "\n";
            }
            $i++;
        }
        if ($message !== null) {
            echo $message;
        }
    }
