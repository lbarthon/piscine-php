<?php
    /**
     * Product page, displays the product whose id is passed in parameter.
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
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

    $query = "SELECT * FROM products WHERE id=" . $_GET['id'];
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        mysqli_close($conn);
        header("Location:./index.php");
        die();
    }

    $product = mysqli_fetch_assoc($result);

    if (isset($_POST) && isset($_POST['productid']) && $_POST['productid'] === $_GET['id']) {
        if ($_SESSION['cart'][$_GET['id']] >= $product['stock']) {
            $added = "<p style='text-align: center;'>Votre panier excède les stocks disponibles!</p>";
        } else {
            $_SESSION['cart'][$_GET['id']] += 1;
            $added = "<p style='text-align: center;'>Produit ajouté au panier!</p>";
        }
    } else {
        $added = "";
    }

    include("templates/header.php");
?>
<div class="milieu" style='font-family: verdana; text-align: right;'>
<div class="accueil">
<table>
    <tr>
        <td><b>Nom: </b><?php echo $product['name']; ?></td>    
        <td ROWSPAN=5 style="width:30%;">
        <img src="<?php echo $product['picture'] ?>" alt="<?php echo $product['name']; ?>" width="70%"></td>    
    </tr>
    <tr>   
        <td><b>Disponibilité: </b><?php echo $product['stock']; ?></td>
        <td ROWSPAN=5></td> 
    </tr>
    <tr>   
        <td><b>Prix: </b><?php echo $product['price']; ?> euros</td>
        <td ROWSPAN=5></td> 
    </tr>
    <tr>
        <td><b>Description: </b><?php echo $product['infos']; ?></td>
        <td>&nbsp</td>
    </tr>
    </table>
</div>
<?php
    echo $added;
    if ($product['stock'] > 0) {
?>
<h1>
    <form action="product.php?id=<?php echo $product['id']; ?>" method="post">
        <input type="hidden" name="productid" value="<?php echo $product['id']; ?>">
        <input style='font-family: verdana; font-size: 14px; color: white; background-color: orange; border-radius: 5px;' type="submit" value="Ajouter au panier">
    </form>
</h1>
</div>
<?php
    } else {
?>
<h1>
    <button style='font-family: verdana; font-size: 14px; color: white; background-color: orange; border-radius: 5px;' type="button">Rupture de stock</button>
</h1>
</div>
<?php
    }
    include("templates/footer.php");
?>