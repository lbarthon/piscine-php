<?php
    /**
     * Order script, called on cart.php form submission ('Commander'button).
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("database.php");
    if (isset($_POST) && isset($_POST['submit']) && $_POST['submit'] === "Commander") {
        if (!isset($_SESSION['email']) || $_SESSION['email'] === "" || $_SESSION['email'] === null) {
            header("Location:./login.php");
            die();
        }

        $conn = mysqli_connect($server, $username, $password, $db);
        if (!$conn) {
            header("Location:./cart.php?error=yes");
            die();
        }
        
        $query = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "'";
        $match = mysqli_query($conn, $query);

        if (!$match || mysqli_num_rows($match) === 0) {
            mysqli_close($conn);
            header("Location:./cart.php?error=yes");
            die();
        }

        $user = mysqli_fetch_assoc($match);

        $cartprice = $_POST['totalprice'];
        $orderstr = "";
        foreach ($_SESSION['cart'] as $key => $value) {
            $query = "SELECT * FROM products WHERE id=" . $key;
            $match = mysqli_query($conn, $query);
            if (!$match || mysqli_num_rows($match) === 0) {
                mysqli_close($conn);
                header("Location:./cart.php?error=yes");
                die();
            }
            $infos = mysqli_fetch_assoc($match);
            $new_stock = $infos['stock'] - $value;
            if ($new_stock < 0) {
                mysqli_close($conn);
                header("Location:./index.php");
                $_SESSION['cart'] = null;
                die();
            }
            $query = "UPDATE products SET stock=" . $new_stock . " WHERE id=" . $key;
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                header("Location:./index.php");
                die();
            }
            $orderstr .= $infos['name'] . " * " . $value . " ";
        }
        $query = "INSERT INTO orders (customerid, date, price, products)" .
            "VALUES('" . $user['id'] . "', '" . time() . "', '" . $cartprice . "', '" . $orderstr . "')";
        if (!mysqli_query($conn, $query)) {
            mysqli_close($conn);
            header("Location:./cart.php?error=yes");
            die();
        }

        $_SESSION['cart'] = null;
        header("Location:./cart.php?validate=yes");
    }
