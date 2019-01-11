<?php
    session_start();
    if (isset($_SESSION['loggued_on_user'])) {
        die($_SESSION['loggued_on_user'] . "\n");
    }
    die("ERROR\n");
