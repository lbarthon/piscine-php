<?php
    /**
     * Install script.
     * Be aware to set good database informations first.
     */
    if (isset($_POST) && isset($_POST['delete']) && $_POST['delete'] === "Supprimer cette page") {
        unlink("install.php");
        header("Location:./index.php");
    }
    else if (isset($_POST) && isset($_POST['submit']) && $_POST['submit'] === "Valider") {
        include("database.php");

        $conn = mysqli_connect($server, $username, $password);
        if (!$conn) {
            die("SQL connection error: " . mysqli_connect_error());
        }

        $query = "CREATE DATABASE IF NOT EXISTS " . $db;
        if (!mysqli_query($conn, $query)) {
            die("Error on query '" . $query . "' " . mysqli_error($conn));
        }
        mysqli_close($conn);

        $conn = mysqli_connect($server, $username, $password, $db);
        if (!$conn) {
            die("SQL connection error: " . mysqli_connect_error());
        }

        $admin_login = mysqli_real_escape_string($conn, $_POST['login']);
        $admin_password = hash("whirlpool", mysqli_real_escape_string($conn, $_POST['password']));

        $queries = array(
            "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            perm_level INT(1) NOT NULL DEFAULT 0,
            nom VARCHAR(40) NOT NULL,
            prenom VARCHAR(40) NOT NULL,
            email VARCHAR(80) NOT NULL,
            pwd VARCHAR(128) NOT NULL,
            tel INT(10) UNSIGNED NOT NULL,
            adresse VARCHAR(150) NOT NULL
            )",
            "CREATE TABLE categories (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(40) NOT NULL
            )",
            "CREATE TABLE products (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(80) NOT NULL,
            price FLOAT(10,2) NOT NULL,
            picture VARCHAR(150) NOT NULL,
            stock INT(6) UNSIGNED,
            infos TEXT
            )",
            "CREATE TABLE orders (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            customerid INT(6) NOT NULL,
            date INT(15) UNSIGNED NOT NULL,
            price FLOAT(50,2) NOT NULL,
            products TEXT
            )",
            "CREATE TABLE link (
            categid INT(6) NOT NULL,
            productid INT(6) NOT NULL
            )",
            "INSERT INTO users (perm_level, nom, prenom, email, pwd, tel, adresse)
            VALUES (1, 'admin', 'admin', '" . $admin_login . "', '" . $admin_password . "', 0, 'admin')",
            "INSERT INTO categories (name) VALUES ('Policiers')",
            "INSERT INTO categories (name) VALUES ('Science-Fiction')",
            "INSERT INTO categories (name) VALUES ('Psychologie')",
            "INSERT INTO products (name, price, picture, stock, infos)
            VALUES ('Policier 1', 9.99, './resources/img/book_policier1.png', 10, 'Très bon polard.')",
            "INSERT INTO products (name, price, picture, stock, infos)
            VALUES ('Policier 2', 19.99, './resources/img/book_policier2.png', 20, 'Très bon polard aussi.')",
            "INSERT INTO products (name, price, picture, stock, infos)
            VALUES ('Science - Fiction 1', 5.99, './resources/img/book_scifi1.jpg', 80, 'Prenant.')",
            "INSERT INTO products (name, price, picture, stock, infos)
            VALUES ('Science - Fiction 2', 7.99, './resources/img/book_scifi2.png', 60, 'Un chef d\'oeuvre.')",
            "INSERT INTO products (name, price, picture, stock, infos)
            VALUES ('Psycho 1', 29.99, './resources/img/book_psy1.png', 3, 'Déprimant...')",
            "INSERT INTO products (name, price, picture, stock, infos)
            VALUES ('Psycho 2', 14.99, './resources/img/book_psy2.png', 5, 'Pour un public restreint.')",
            "INSERT INTO link (categid, productid) VALUES (1, 1)",
            "INSERT INTO link (categid, productid) VALUES (1, 2)",
            "INSERT INTO link (categid, productid) VALUES (2, 3)",
            "INSERT INTO link (categid, productid) VALUES (2, 4)",
            "INSERT INTO link (categid, productid) VALUES (3, 5)",
            "INSERT INTO link (categid, productid) VALUES (3, 6)",
            "INSERT INTO link (categid, productid) VALUES (1, 3)"
        );

        foreach ($queries as $query) {
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
        }
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ft_minishop: install</title>
</head>
<body>
    <h2>Please consider deleting this page when installation is over.</h2>
    <p>You should first set good informations in databases.php</p>
    <p>Installation -- First admin account</p>
    <form action="install.php" method="post">
        <input type="text" name="login" placeholder="Admin Login" required><br>
        <input type="password" name="password" placeholder="Admin Password" required><br>
        <input type="submit" name="submit" value="Valider"><br><br>
    </form>
    <form action="install.php" method="post">
        <input type="submit" name="delete" value="Supprimer cette page">
    </form>
</body>
</html>