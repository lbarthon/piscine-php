#!/usr/bin/php
<?php
    if ($argc >= 2) {
        $file = fopen($argv[1], "r") or exit("Unable to open file " . $argv[1]);
        $text = fread($file, filesize($argv[1]));
        $text = preg_replace_callback("/(<[^>]*title=\")([^\"]+)/", function ($word) {
            return $word[1] . strtoupper($word[2]);
        }, $text);
        $text = preg_replace_callback("/<a.*>(.*)</a>/", function ($word) {
            echo "1er match : " . $word[0] . "\n";
            return preg_replace_callback("/([^<]*)(<.+>)/", function ($match) {
                echo "2e match : " . $word[0] . "\n";
                return $word[1] . strtoupper($word[2]);
            }, $word[0]);
        }, $text);
        echo $text;
        fclose($file);
    }
