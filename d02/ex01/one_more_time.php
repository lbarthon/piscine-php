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
            case "janvier": return 1;
            case "février": return 2;
            case "mars": return 3;
            case "avril": return 4;
            case "mai": return 5;
            case "juin": return 6;
            case "juillet": return 7;
            case "août": return 8;
            case "septembre": return 9;
            case "octobre": return 10;
            case "novembre": return 11;
            case "décembre": return 12;
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
        if (preg_match("/^((2)[0-3]|[0-1]\d):([0-5]\d):([0-5]\d)/", $array[4]) !== 1 ||
            strlen($array[4]) !== 8) {
            die("Wrong Format\n");
        }
        $array[2] = get_month($array[2]);
        if ($array[2] === false || strlen($array[3]) < 4) {
            die("Wrong Format\n");
        }
        if ($array[3] < 1970) {
            die("Wrong Format\n");
        }
        if (preg_match("/^[1-9]/", $array[1]) !== 1 && strlen($array[1]) === 1) {
            die("Wrong Format\n");
        }
        if (preg_match("/^([0-2]\d|(3)[0-1])/", $array[1]) !== 1 && strlen($array[1]) === 2) {
            die("Wrong Format\n");
        }
        if (strlen($array[1]) !== 1 && strlen($array[1]) !== 2) {
            die("Wrong Format\n");
        }
        date_default_timezone_set("CET");
        echo strtotime($array[2] . "/" . $array[1] . "/" . $array[3] . " " . $array[4]) . "\n";
    }
