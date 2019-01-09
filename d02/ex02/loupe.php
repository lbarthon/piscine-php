#!/usr/bin/php
<?php
    if ($argc >= 2) {
        $file = fopen($argv[1], "r") or exit("Unable to open file " . $argv[1]);
        $text = fread($file, filesize($argv[1]));
        $text = preg_replace_callback("/(<[^>]*title=\")([^\"]+)/", function ($word) {
            return $word[1] . strtoupper($word[2]);
        }, $text);
        $text = preg_replace_callback("/(<a.*?)(>.*<)(\/a>)/s", function ($word) {
            return $word[1] . 
                preg_replace_callback("/(>\n?)([^<>]*)(\n?<)/s", function ($match) {
                    return $match[1] . strtoupper($match[2]) . $match[3];
                }, $word[2])
            . $word[3];
        }, $text);
        echo $text;
        fclose($file);
    }
