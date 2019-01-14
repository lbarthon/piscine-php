<?php
    /**
     * This file is included in every .php in the admin folder.
     * It wil basically redirect user to index.php if he isn't admin.
     * Admin means that his perm_level is equal to 1.
     */
    include("../database.php");

    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        header("Location:../index.php");
        die();
    }

    session_start();
    if (isset($_SESSION['email']) && $_SESSION['email'] !== null && $_SESSION['email'] !== "") {
        $email = $_SESSION['email'];
        $query = "SELECT * FROM users WHERE email='" . $email . "'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if ($user['perm_level'] != 1) {
                mysqli_close($conn);
                header("Location:../index.php");
                die();
            }
        }
    } else {
        mysqli_close($conn);
        header("Location:../index.php");
        die();
    }

    mysqli_close($conn);
