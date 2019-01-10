<?php
    if (isset($_GET) && isset($_GET['action']) && isset($_GET['name'])) {
        $action = $_GET['action'];
        $name = $_GET['name'];
        switch ($action) {
            case "set":
                if (isset($_GET['value'])) {
                    setcookie($name, $_GET['value'], time() + 3600);
                }
                break;
            case "get":
                echo isset($_COOKIE[$name]) && $_COOKIE[$name] != null ? $_COOKIE[$name] . "\n" : "";
                break;
            case "del":
                if (isset($_COOKIE[$name])) {
                    unset($_COOKIE[$name]);
                    setcookie($name, null, -1);
                }
                break;
        }
    }
