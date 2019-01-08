#!/usr/bin/php
<?php
    if ($argc == 2 && ($argv[1] === "moyenne" ||
            $argv[1] === "moyenne_user" || $argv[1] === "ecart_moulinette")) {
        $throw = fgets(STDIN);
        $array = array();
        $notes = array();
        $mouli = array();
        $data = array();
        while (feof(STDIN) !== true) {
            $array[] = fgets(STDIN);
        }
        if ($array != null) {
            sort($array);
            foreach ($array as $str) {
                $data[] = str_getcsv($str, ";");
            }
            if ($argv[1] === "moyenne") {
                foreach ($data as $line) {
                    if ($line[2] !== "moulinette" && $line[1] !== "" && $line[1] !== null) {
                        $notes[] = $line[1];
                    }
                }
                echo array_sum($notes) / count($notes) . "\n";
            } else if ($argv[1] === "moyenne_user") {
                foreach ($data as $line) {
                    if ($line[2] !== "moulinette" && $line[1] !== "" && $line[1] !== null) {
                        $notes[$line[0]][] = $line[1];
                    }
                }
                foreach ($notes as $user => $note) {
                    echo $user . ":" . array_sum($note) / count($note) . "\n";
                }
            } else if ($argv[1] === "ecart_moulinette") {
                foreach ($data as $line) {
                    if ($line[2] !== "moulinette" && $line[1] !== "" && $line[1] !== null) {
                        $notes[$line[0]][] = $line[1];
                    } else if ($line[2] === "moulinette" && $line[1] !== "" && $line[1] !== null) {
                        $mouli[$line[0]] = $line[1];
                    }
                }
                foreach ($notes as $user => $note) {
                    echo $user . ":" . ((array_sum($note) / count($note)) - $mouli[$user]) . "\n";
                }
            }
        }
    }
