<?php
    /**
     * Logout script.
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['email'] = "";
    header("Location:./index.php");
