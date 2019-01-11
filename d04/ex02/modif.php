<?php
    if (isset($_POST) && isset($_POST['submit']) && isset($_POST['login']) && isset($_POST['oldpw']) && isset($_POST['newpw'])) {
        if ($_POST['submit'] === "OK" && $_POST['newpw'] !== "") {
            $login = $_POST['login'];
            $oldpw = $_POST['oldpw'];
            $newpw = $_POST['newpw'];
            $content = file_get_contents("../private/passwd");
            if ($content !== null) {
                $users = unserialize($content);
            } else {
                die ("ERROR\n");
            }
            $userkey = -1;
            foreach ($users as $key=>$user) {
                if ($user['login'] === $login) {
                    if (hash("whirlpool", $oldpw) === $user['passwd']) {
                        $userkey = $key;
                        break;
                    }
                    die("ERROR\n");
                }
            }
            if ($userkey === -1) die ("ERROR\n");
            $users[$userkey]['passwd'] = hash("whirlpool", $newpw);
            file_put_contents("../private/passwd", serialize($users));
            die("OK\n");
        }
    }
    die("ERROR\n");
