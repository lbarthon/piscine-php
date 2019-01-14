<?php
    /**
     * Page that allows users to destroy & edit their accounts.
     */
    include("templates/header.php");
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['email']) && $_SESSION['email'] !== "" && $_SESSION['email'] !== null) {
        $conn = mysqli_connect($server, $username, $password, $db);
        if (!$conn) {
            header("Location:./index.php");
            die();
        }
        
        $query = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $infos = mysqli_fetch_assoc($result);
            $id = $infos['id'];
        } else {
            mysqli_close($conn);
            header("Location:./index.php");
            die();
        }

        if (isset($_POST) && isset($_POST['delete']) && $_POST['delete'] !== null && $_POST['delete'] !== "") {
            $query = "DELETE FROM users WHERE email='" . $_SESSION['email'] . "'";

            $_SESSION['email'] = "";

            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                header("Location:./index.php");
                die();
            }
        } else if (isset($_POST) && isset($_POST['edit']) && $_POST['edit'] !== null && $_POST['edit'] !== "") {
            $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
            $adresse = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['adresse']));
            $tel = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['tel']));
            $prenom = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['prenom']));
            $nom = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['nom']));

            $query = "UPDATE users SET email='" . $email .
                "', adresse='" . $adresse .
                "', tel='" . $tel .
                "', prenom='" . $prenom .
                "', nom='" . $nom . "' WHERE id=" . $id;

            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                header("Location:./index.php");
                die();
            }

            $_SESSION['email'] = $email;
        }

        $query = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $infos = mysqli_fetch_assoc($result);
        } else {
            mysqli_close($conn);
            header("Location:./index.php");
            die();
        }

        mysqli_close($conn);
    }
?>
<div class="milieu" style='text-align: left; font-family: verdana;'>
    Mon compte   
    <div class="accueil">
        <form class="formaccount" action="myaccount.php" method="post">
            <label Class="label">Nom: </label>
            <input type="text" name="nom" value="<?php echo $infos['nom']; ?>" autofocus>
            <br>
            <label Class="label">Prénom:</label>
            <input type="text" name="prenom" value="<?php echo $infos['prenom']; ?>">
            <br>
            <label Class="label">Email:</label>
            <input type="email" name="email" value="<?php echo $infos['email']; ?>">
            <br>
            <label Class="label">Téléphone:</label>
            <input type="tel" name="tel" value="<?php echo $infos['tel']; ?>">
            <br>
            <label Class="label">Adresse:</label>
            <input type="text" name="adresse" value="<?php echo $infos['adresse']; ?>">
            <br>
            <?php
                if (isset($_GET['error']) && $_GET['error'] === "yes") {
                    echo "<p color='red'>Erreur lors des modifications.</p>";
                }
            ?>
            <br>        
            <input style='font-family: verdana; font-size: 14px; color: white; background-color: orange; border-radius: 5px;' type="submit" name="edit" value="Valider les modifications">
        </form>
        <form action="myaccount.php" method="post">
            <input style='font-family: verdana; font-size: 14px; color: white; background-color: orange; border-radius: 5px;' type="submit" name="delete" value="Supprimer mon compte">
        </form>
    </div>
</div>
<?php
    include("templates/footer.php");
?>