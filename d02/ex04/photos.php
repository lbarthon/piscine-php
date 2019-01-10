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
        $content = curl_exec($ch);
        curl_close($ch);
        preg_match_all("/<img.*src=['\"].*?['\"].*?>/i", $content, $matches);
        if (count($matches[0]) > 0) {
            $dir = getcwd() . "/" . str_replace("/", "-", str_replace("http://", "", str_replace("https://", "", $argv[1])));
            $dir = preg_replace("/-$/", "", $dir);
            if (!file_exists($dir) && !is_dir($dir)) mkdir($dir);
            chdir($dir);
            foreach ($matches[0] as $old) {
                preg_match_all("/src=['\"](.*?)['\"]/i", $old, $match);
                foreach ($match[1] as $link) {
                    $explode = explode("/", $link);
                    $name = $explode[count($explode) - 1];
                    $url = $link;
                    if (starts_with($url, "http") === false) {
                        $url = $argv[1] . "/" . $link;
                    }
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $img = curl_exec($ch);
                    curl_close($ch);
                    $file = fopen($name, 'w');
                    fwrite($file, $img);
                    fclose($file);
                }
            }
        }
    }
