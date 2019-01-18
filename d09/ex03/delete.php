<?php
    if (isset($_POST) && $_POST !== null && $_POST['id'] !== null && $_POST['id'] !== "") {
        $file = fopen("list.csv", "r");
        if ($file) {
            flock($file, LOCK_EX);
            $array = [];
            while ($csv = fgetcsv($file, 0, ";")) {
                $array[] = $csv;
            }
            fclose($file);

            $file = fopen("list.csv", "w");
            flock($file, LOCK_EX);
            $i = 0;
            while ($i < count($array)) {
                if ($array[$i][0] == $_POST['id']) {
                    break;
                }
                $i++;
            }
            array_splice($array, $i, 1);
            foreach ($array as $line) {
                fputcsv($file, $line, ";");
            }
            fclose($file);
            die("ALL OK");
        }
    }
