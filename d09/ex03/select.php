<?php
    if (isset($_POST) && $_POST !== null && $_POST['val'] !== null && $_POST['val'] !== "") {
        $file = fopen("list.csv", "r");
        if ($file) {
            flock($file, LOCK_EX);
            $array = [];
            while ($csv = fgetcsv($file, 0, ";")) {
                $array[] = $csv;
            }
            flock($file, LOCK_UN);
            fclose($file);
            echo json_encode($array);
        }
    }
