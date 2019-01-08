#!/usr/bin/php
<?php
    function is_day($str) {
        if ($str !== "lundi" && $str !== "mardi" && $str !== "mercredi" && $str !== "jeudi" &&
            $str !== "vendredi" && $str !== "samedi" && $str !== "dimanche") {
            return false;
        }
        return true;
    }

    function get_month($str) {
        switch ($str) {
            case "janvier": return 0;
            case "février": return 31;
            case "mars": return 59;
            case "avril": return 90;
            case "mai": return 120;
            case "juin": return 151;
            case "juillet": return 181;
            case "août": return 212;
            case "septembre": return 243;
            case "octobre": return 273;
            case "novembre": return 304;
            case "décembre": return 334;
            default: return false;
        }
    }

    if ($argc >= 2) {
        $array = explode(" ", $argv[1]);
        if (count($array) !== 5){
            die("Wrong Format\n");
        }
        $array[0] = strtolower($array[0]);
        $array[2] = strtolower($array[2]);
        if (is_numeric($array[1]) === false || is_numeric($array[3]) === false) {
            die("Wrong Format\n");
        }
        if (is_day($array[0]) === false) {
            die("Wrong Format\n");
        }
        if (preg_match("/^((2)[0-3]|[0-1]\d):([0-5]\d):([0-5]\d)/", $array[4]) === 0 ||
            strlen($array[4]) !== 8) {
            die("Wrong Format\n");
        }
        $array[2] = get_month($array[2]);
        if ($array[2] === false || strlen($array[3]) < 4) {
            die("Wrong Format\n");
        }
        $array[3] -= 1970;
        if ($array[3] < 0) {
            die("Wrong Format\n");
        }
        if (preg_match("/^\d/", $array[1]) === 0 && strlen($array[1]) === 1) {
            die("Wrong Format\n");
        }
        if (preg_match("/^([1-2]\d|(3)[0-1])/", $array[1]) === 0 && strlen($array[1]) === 2) {
            die("Wrong Format\n");
        }
        if (strlen($array[1]) !== 1 && strlen($array[1]) !== 2) {
            die("Wrong Format\n");
        }
        $seconds = $array[3] * 31536000;
        $seconds += $array[2] * 3600 * 24;
    }
