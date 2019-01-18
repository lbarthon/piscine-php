<?php
    if (isset($_POST) && $_POST !== null && $_POST['id'] !== null && $_POST['id'] !== "") {
        $add = $_POST['id'] . ";" . $_POST['text'] . "\n";
        file_put_contents("list.csv", file_get_contents("list.csv") . $add);
    }
