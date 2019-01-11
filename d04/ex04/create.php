<?php
    if (isset($_POST) && isset($_POST['submit']) && isset($_POST['login']) && isset($_POST['passwd'])) {
        if ($_POST['submit'] === "OK" || $_POST['login'] !== "" || $_POST['passwd'] !== "") {
            $login = $_POST['login'];
            $passwd = $_POST['passwd'];
            if (file_exists("../private/passwd")) {
                $users = unserialize(file_get_contents("../private/passwd"));
            } else {
                mkdir("../private");
                $users = array();
            }
            foreach ($users as $user) {
                if ($user['login'] === $login) {
                    die("ERROR\n");
                }
            }
            $users[] = array("login"=>$login, "passwd"=>hash("whirlpool", $passwd));
            file_put_contents("../private/passwd", serialize($users));
            echo "OK\n";
            header("Location:./index.html");
            die();
        }
    }
    die("ERROR\n");
