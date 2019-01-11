<?php
    session_start();
    $user = $_SESSION['loggued_on_user'];
    if (!isset($user) || $user === null) {
        header("Location:./index.html");
        die();
    }
    if (file_exists("../private/chat")) {
        $messages = unserialize(file_get_contents("../private/chat"));
    } else {
        die();
    }
    foreach ($messages as $msg) {
        echo "[" . date("H:i", $msg['time']) . "] ";
        echo "<b>" . $msg['login'] . "</b>: ";
        echo $msg['msg'] . "<br />";
    }
