<?php
    /**
     * Header file, contains the top of the front office (every pages).
     */
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ft_minishop</title>
</head>
<body>
<?php
    /**
     * Here we get values that will be used to print only links client should see.
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['email']) && $_SESSION['email'] !== null && $_SESSION['email'] !== "") {
        include("database.php");
        $conn = mysqli_connect($server, $username, $password, $db);
        
        if (!$conn) {
            header("Location:./index.php");
            die();
        }

        $query = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "'";
        $result = mysqli_query($conn, $query);

        $perm_level = 0;
        $logged = 0;

        if ($result && mysqli_num_rows($result) > 0) {
            $infos = mysqli_fetch_assoc($result);
            $perm_level = $infos['perm_level'];
            $logged = 1;
        }
    } else {
        $perm_level = 0;
        $logged = 0;
    }

    if (isset($_SESSION['cart']) && $_SESSION['cart'] !== null && $_SESSION['cart'] !== "") {
        $cartsize = 0;
        foreach ($_SESSION['cart'] as $key => $value) {
            $cartsize += $value;
        }
    } else {
        $cartsize = 0;
    }
?>
<div class="header">
    <div class="logo">
        <a href="index.php"><img class="logo" SRC="resources/img/logo.png" alt="logo" title="Home" style="width:100px;height:100px;"></a>
    </div>
    <?php
        if ($logged === 1) {
    ?>
    <div class="pictouser">
        <a href="myaccount.php"><img SRC="resources/img/picto_user.png" alt="user" title="Moi" style="width:40px;height:40px;"></a>
    </div>
    <?php
        } else {
    ?>
    <div class="pictouser">
        <a href="login.php"><img SRC="resources/img/picto_user.png" alt="user" title="Moi" style="width:40px;height:40px;"></a>
    </div>
    <?php
        }
    ?>
    <div class="infopanier">
        <h3 style="color: orange;"> <?php echo $cartsize; ?> articles </h3>
    </div>
    <div class="pictopanier">
        <a href="cart.php"><img SRC="resources/img/picto_panier.png" alt="panier" title="panier" style="width:40px;height:40px;"></a>
    </div>
    <?php
        if ($logged === 1) {
    ?>
    <div class="pictodeconn">
        <a href="logout.php"><img SRC="resources/img/deconnect.png" alt="deconnexion" title="Se déconnecter" style="width:45px;height:40px;"></a>
    </div> 
    <?php
        }
        if ($perm_level == 1) {
    ?>
    <div class="pictoadmin">
        <a href="admin/index.php"><img SRC="resources/img/admin.png" alt="Accès administration" title="Accès administration" style="width:50%"></a>
    </div>
    <?php
        }
    ?>
</div>
<div>
    <div class="navheader">
        <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <?php
                /**
                 * Printing all categories.
                 */
                include("database.php");
                $conn = mysqli_connect($server, $username, $password, $db);
                if ($conn){
                    $query = "SELECT * FROM categories";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0){
                        while ($infos = mysqli_fetch_assoc($result)) {
                            echo "<li><a href='category.php?id=" . $infos['id'] . "'>" . $infos['name'] . "</a></li>";
                        }
                    }
                }
            ?>
        </ul>
</div>
<div style="clear:both;"></div>
</div>