<?php
    /**
     * Category page. Displays information about the category whose id is passed in parameter.
     */
    if (!isset($_GET) || !isset($_GET['id'])) {
        header("Location:./index.php");
        die();
    }
    include("database.php");
    
    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        header("Location:./index.php");
        die();
    }

    $query = "SELECT * FROM categories WHERE id=" . $_GET['id'];
    $categ = mysqli_query($conn, $query);

    if (!$categ || mysqli_num_rows($categ) === 0) {
        mysqli_close($conn);
        header("Location:./index.php");
        die();
    }

    $query = "SELECT productid FROM link WHERE categid=" . $_GET['id'];
    $products = mysqli_query($conn, $query);

    if (!$products || mysqli_num_rows($products) === 0) {
        mysqli_close($conn);
        header("Location:./index.php");
        die();
    }

    include("templates/header.php");
?>
<div class="milieu">
<div class="accueil">
<div style='text-align: center;'>
<?php
    $added = array();
    while ($link = mysqli_fetch_assoc($products)) {
        $productid = $link['productid'];
        if (!isset($added[$productid])) {
            $query = "SELECT * FROM products WHERE id=" . $productid;
            $product = mysqli_query($conn, $query);
            if (!$product || mysqli_num_rows($product) === 0) {
                mysqli_close($conn);
                die("Error loading product with id=" . $productid . " in category with id=" . $_GET['id']);
            }
            $infos = mysqli_fetch_assoc($product);
            echo "<div class='catproduct'>";
            echo "<h1>" . $infos['name'] . "</h1>";
            echo "<a href='product.php?id=" . $productid . "'><img src='" . $infos['picture'] .
                "' alt='" . $infos['name'] . "' width='30%'></a>";
            echo "<h2>Plus d'infos</h2>";
            echo "</div>";
        }
        $added[$productid] = 1;
    }
    echo "<div style='clear:both;'></div>";
?>
</div>
</div>
</div>
<?php
    include("templates/footer.php");
?>