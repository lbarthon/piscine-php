<?php
    include("auth.php");
    if (isset($_GET) && isset($_GET['login']) && isset($_GET['passwd'])) {
        $login = $_GET['login'];
        $passwd = $_GET['passwd'];
        session_start();
        if (auth($login, $passwd)) {
            $_SESSION['loggued_on_user'] = $login;
            die("OK\n");
        } else {
            $_SESSION['loggued_on_user'] = null;
            die("ERROR\n");
        }
    }
