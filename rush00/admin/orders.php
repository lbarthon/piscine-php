<?php
    include("checks.php");
        
    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        die("SQL connection error: " . mysqli_connect_error());
    }

    /**
     * Listens to order deletion.
     */
    if (isset($_POST) && (isset($_POST['submit']) && $_POST['submit'] === "Del")) {
        $query = "DELETE FROM orders WHERE id=" . $_POST['id'];
        if (!mysqli_query($conn, $query)) {
            mysqli_close($conn);
            die("Error on query '" . $query . "' " . mysqli_error($conn));
        }
    }

    include("templates/header.php");

    $query = "SELECT * FROM orders";
    $orders = mysqli_query($conn, $query);

    /**
     * Displays orders format.
     */
    echo "<div class='center'>";
    echo "<ul class='ordersinfos'><li>ID</li><li>Client ID</li><li>Date de la commande</li><li>Prix payé</li><li>Produits achetés</li></ul>";

    if ($orders && mysqli_num_rows($orders) > 0) {
        /**
         * Displays all orders.
         */
        while ($order = mysqli_fetch_assoc($orders)) {
            echo "<form action='orders.php' method='post'>";
            echo "<ul class='order'>";
            echo "<li>" . $order['id'] . "</li>";
            echo "<li>" . $order['customerid'] . "</li>";
            echo "<li>" . date("d/m/Y H:i:s", $order['date']) . "</li>";
            echo "<li>" . $order['price'] . " euros</li>";
            echo "<li>" . $order['products'] . "</li>";
            echo "<input type='hidden' name='id' value='" . $order['id'] . "'>";
            echo "<input class='orderbutton' type='submit' name='submit' value='Del'>";
            echo "</ul>";
            echo "</form>";
        }
    } else {
        echo "<h1 style='text-align:center;'>Error loading orders...</h1>";
    }

    mysqli_close($conn);
    echo "</div>";

    include("templates/footer.php");
