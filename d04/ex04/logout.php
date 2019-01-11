<?php
    session_start();
    $_SESSION['loggued_on_user'] = null;
    header("Location:./index.html");
