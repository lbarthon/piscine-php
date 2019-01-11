#!/usr/bin/php
<?php
    if ($argc >= 2) {
        $regexp = "/[\t ]+/";
        $array = preg_split($regexp, trim($argv[1]));
        $len = count($array);
        $i = 1;
            foreach ($array as $value) {
            echo $value . ($i === $len ? "\n" : " ");
            $i++;
        }
    }
