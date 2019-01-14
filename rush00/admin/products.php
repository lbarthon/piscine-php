<?php
    include("checks.php");
        
    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        die("SQL connection error: " . mysqli_connect_error());
    }

    if (isset($_POST) && (isset($_POST['submit']) && $_POST['submit'] === "OK") ||
            (isset($_POST['addprod']) && $_POST['addprod'] === "OK")) {
        if (isset($_POST['addprod']) && $_POST['addprod'] === "OK") {
            /**
             * Listens to add product form.
             */
            $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']));
            $price = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['price']));
            $stock = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['stock']));
            $infos = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['infos']));
            file_put_contents("../resources/img/" . $name . ".jpg",
                file_get_contents(htmlspecialchars($_POST['picture'])));
            $picture = "./resources/img/" . $name . ".jpg";
            $query = "INSERT INTO products (name, price, picture, stock, infos) VALUES ('" .
                $name . "', '" . $price . "', '" . $picture . "', '" . $stock . "', '" . $infos . "')";
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
        }
        else if (isset($_POST['keep']) && $_POST['keep'] === "keep") {
            /**
             * Listens to edit product form.
             */
            $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']));
            $price = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['price']));
            $picture = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['picture']));
            $stock = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['stock']));
            $infos = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['infos']));
            $query = "UPDATE products SET name='" . $name . "', price='" .
                $price . "', picture='" . $picture . "', stock='" . $stock .
                "', infos='" . $infos . "' WHERE id=" . $_POST['id'];
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
        } else {
            /**
             * Listens to delete product form.
             */
            $query = "SELECT picture FROM products WHERE id=" . $_POST['id'];
            $pictures = mysqli_query($conn, $query);
            if ($pictures && mysqli_num_rows($pictures) > 0) {
                while ($picture = mysqli_fetch_assoc($pictures)) {
                    if (preg_match("/http/i", $picture['picture']) === 0) {
                        unlink($picture['picture']);
                    }
                }
            }
            $query = "DELETE FROM products WHERE id=" . $_POST['id'];
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
            $query = "DELETE FROM link WHERE productid=" . $_POST['id'];
        }
    }

    include("templates/header.php");

    $query = "SELECT * FROM products";
    $products = mysqli_query($conn, $query);

    echo "<div class='center'>";
    echo "<ul class='prodinfos'><li>ID</li><li>Nom</li><li>Prix</li><li>Photo</li><li>Stock</li><li>Infos</li></ul>";

    if ($products && mysqli_num_rows($products) > 0) {
        /**
         * Displays all products as forms. All editable and deletable.
         */
        while ($product = mysqli_fetch_assoc($products)) {
            echo "<form action='products.php' class='prodform' method='post'>";
            echo "<input class='nowidth' type='checkbox' name='keep' value='keep' title='Keep?' checked>";
            echo "<p>" . $product['id'] . "</p>";
            echo "<input type='hidden' name='id' value='" . $product['id'] . "'>";
            echo "<input type='text' name='name' value='" . $product['name'] . "'>";
            echo "<input type='text' name='price' value='" . $product['price'] . "'>";
            echo "<input type='text' name='picture' value='" . $product['picture'] . "'>";
            echo "<input type='text' name='stock' value='" . $product['stock'] . "'>";
            echo "<input type='text' name='infos' value='" . $product['infos'] . "'>";
            echo "<input class='nowidth' type='submit' name='submit' value='OK'>";
            echo "</form>";
        }
    } else {
        echo "<h1 style='text-align:center;'>Error loading products...</h1>";
    }

    /**
     * Add product form
     */
    echo "<br>";
    echo "<form action='products.php' class='adduserform' method='post'>";
    echo "Add product: <input type='text' name='name' placeholder='Nom du produit' required>";
    echo "<input type='text' name='price' placeholder='Prix' required>";
    echo "<input type='text' name='picture' placeholder='Lien vers sa photo (JPG ONLY)' required>";
    echo "<input type='text' name='stock' placeholder='Stock' required>";
    echo "<input type='text' name='infos' placeholder='Description' required>";
    echo "<input class='nowidth' type='submit' name='addprod' value='OK'>";
    echo "</form>";

    mysqli_close($conn);
    echo "</div>";

    include("templates/footer.php");
