#!/usr/bin/php
<?php
    function starts_with ($string, $start) 
    {
        $len = strlen($start);
        return (substr($string, 0, $len) === $start);
    }

    if ($argc >= 2) {
        $ch = curl_init($argv[1]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        preg_match_all("/<img.*src=\".*?\".*>/i", $content, $matches);
        if (count($matches[0]) > 0) {
            $dir = getcwd() . "/" . str_replace("http://", "", str_replace("https://", "", $argv[1]));
            if (!file_exists($dir) && !is_dir($dir)) mkdir($dir);
            chdir($dir);
            foreach ($matches[0] as $old) {
                preg_match("/src=\"(.*?)\"/i", $old, $match);
                if ($match[1] !== null) {
                    $explode = explode("/", $match[1]);
                    $name = $explode[count($explode) - 1];
                    $url = $match[1];
                    if (starts_with($url, "http") === false) {
                        $url = $argv[1] . "/" . $match[1];
                    }
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                    $img = curl_exec($ch);
                    curl_close($ch);
                    $file = fopen($name, 'w');
                    fwrite($file, $img);
                    fclose($file);
                }
            }
        }
    }
