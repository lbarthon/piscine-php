<?php
    /**
     * Cart page. Displays user's cart.
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("database.php");
    if (!isset($_SESSION['cart']) || $_SESSION['cart'] === null || $_SESSION['cart'] === "") {
        header("Location:./index.php");
        die();
    }

    if (isset($_POST)) {
        if (isset($_POST['vider']) && $_POST['vider'] !== null && $_POST['vider'] !== "") {
            unset($_SESSION['cart']);
            $_SESSION['cart'] = null;
            header("Location:./index.php");
            die();
        }
    }

    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        header("Location:./index.php");
        die();
    }
    
    include("templates/header.php");
?>
<div class="milieu" style='text-align: left; font-family: verdana;'>
        <div class="accueil">
            <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $value) {
                    $query = "SELECT * FROM products WHERE id=" . $key;
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $product = mysqli_fetch_assoc($result);
                        echo "<div class='recaparticle'> 
                        <div>
                            <img src='" . $product['picture'] . "' alt='" . $product['name'] . "' width='40%'>
                        </div>
                        <div class='containerarticle'>
                                <p class='containerarticle'>" . $product['name'] . "*" . $value . "</p>
                        </div>
                        <div class='containerarticle'>
                                <p class='containerarticle'>" . $product['price'] . "</p>
                        </div>
                        <div>
                            <img src='resources/img/trash.png' alt='Trash can' width='40%'> </a>
                        </div>
                        </div>";
                        $total += $value * $product['price'];
                    }
                }
            ?>
            <div class="recapprix" style='text-align: right; font-family: verdana; font-size: 14px;'> 
                <div class="containerprix"> 
                    <td class="containerprix">Total : <?php echo $total; ?></td>
                </div>
                <div class="containerprix"> 
                    <td class="containerprix">Frais de livraison : offerts !</td>
                </div>
            </div>
        </div>
</div>
<?php
    if (isset($_GET['error']) && $_GET['error'] === yes) {
        echo "<p style='color: red; text-align: center;'>Erreur lors de la validation du panier!</p>";
    }
    /**
     * 'Commander' button is only reachable when user is logged (otherwise will redirect to login page).
     */
?>
<h1>
<form action="order.php" method="post">
    <input type="hidden" name="totalprice" value="<?php echo $total; ?>">
    <input style='font-family: verdana; font-size: 14px; color: white; background-color: orange; border-radius: 5px;' type="submit" name="submit" value="Commander">
</form>
<form action="cart.php" method="post">
    <input style='font-family: verdana; font-size: 14px; color: white; background-color: orange; border-radius: 5px;' type="submit" name="vider" value="Vider le panier">
</form>
</h1>
<?php
    include("templates/footer.php");
    mysqli_close($conn);
?>