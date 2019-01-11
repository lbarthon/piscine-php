<?php
    function auth($login, $passwd) {
        $passwd = hash("whirlpool", $passwd);
        $users = unserialize(file_get_contents("../private/passwd"));
        foreach ($users as $user) {
            if ($user['login'] === $login) {
                if ($user['passwd'] === $passwd) {
                    return true;
                }
                break;
            }
        }
        return false;
    }
