<?php
    include("checks.php");
    
    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        die("SQL connection error: " . mysqli_connect_error());
    }

    if (isset($_POST) && (isset($_POST['submit']) && $_POST['submit'] === "OK") ||
            (isset($_POST['addcateg']) && $_POST['addcateg'] === "OK")) {
        if (isset($_POST['addcateg']) && $_POST['addcateg'] === "OK") {
            /**
             * Listens to add category form.
             */
            $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']));
            $query = "INSERT INTO categories (name) VALUES ('" . $name . "')";
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
        } else if (isset($_POST['keep']) && $_POST['keep'] === "keep") {
            /**
             * Listens to edit category.
             */
            $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']));
            $products = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['products']));
            $query = "UPDATE categories SET name='" . $name . "' WHERE id='" . $_POST['id'] . "'";
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
            $query = "DELETE FROM link WHERE categid=" . $_POST['id'];
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
            $products = explode(", ", $products);
            foreach ($products as $product) {
                if (!isset($product) || $product === "" || $product === null) break;
                $query = "INSERT INTO link (categid, productid) VALUES (" . $_POST['id'] . ", " . $product . ")";
                if (!mysqli_query($conn, $query)) {
                    mysqli_close($conn);
                    die("Error on query '" . $query . "' " . mysqli_error($conn));
                }
            }
        } else {
            /**
             * Listens to delete category.
             */
            $query = "DELETE FROM categories WHERE id=" . $_POST['id'];
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
            $query = "DELETE FROM link WHERE categid=" . $_POST['id'];
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
        }
    }

    include("templates/header.php");

    $query = "SELECT * FROM categories";
    $categories = mysqli_query($conn, $query);

    $query = "SELECT * FROM link";
    $links = mysqli_query($conn, $query);

    $products = array();
    if ($links && mysqli_num_rows($links) > 0) {
        while ($link = mysqli_fetch_assoc($links)) {
            $products[$link['categid']][] = $link['productid'];
        }
    }

    /**
     * Displays category format.
     */
    echo "<div class='center'>";
    echo "<ul class='categinfos'><li>Nom</li><li>ID Produits séparés par ', '</li></ul>";

    if ($categories && mysqli_num_rows($categories) > 0) {
        /**
         * Prints every category.
         */
        while ($category = mysqli_fetch_assoc($categories)) {
            if (isset($products[$category['id']])) {
                $print = implode(", ", $products[$category['id']]);
            } else {
                $print = "";
            }
            echo "<form action='categories.php' class='categform' method='post' id='categedit'>";
            echo "<input class='nowidth' type='checkbox' name='keep' value='keep' title='Keep?' checked>";
            echo "<input type='hidden' name='id' value='" . $category['id'] . "'>";
            echo "<input type='text' name='name' value='" . $category['name'] . "'>";
            echo "<input type='text' name='products' value='" . $print . "'>";
            echo "<input class='nowidth' type='submit' name='submit' value='OK'>";
            echo "</form>";
        }
    } else {
        echo "<h1 style='text-align:center;'>Error loading categories...</h1>";
    }

    /**
     * Add category form
     */
    echo "<br>";
    echo "<form action='categories.php' class='categform addcategform' method='post'>";
    echo "Add category: <input type='text' name='name' placeholder='Nom de la catégorie' required>";
    echo "<input class='nowidth' type='submit' name='addcateg' value='OK'>";
    echo "</form>";

    mysqli_close($conn);
    echo "</div>";

    include("templates/footer.php");
