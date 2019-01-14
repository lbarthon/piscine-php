<?php
    /**
     * Login page.
     * Allows user to create an account too.
     */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("database.php");

    if (isset($_POST)) {
        $conn = mysqli_connect($server, $username, $password, $db);
        if (!$conn) {
            header("Location:./login.php?error=yes");
            die();
        }

        if (isset($_POST['login'])) {
            $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
            $password = hash("whirlpool", $_POST['password']);
            $query = "SELECT * FROM users WHERE email='" . $email . "'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $infos = mysqli_fetch_assoc($result);
                if ($infos['pwd'] === $password) {
                    $_SESSION['email'] = $email;
                    header("Location:./index.php");
                } else {
                    $_SESSION['email'] = "";
                    header("Location:./login.php?error=yes");
                }
                mysqli_close($conn);
                die();
            }
            mysqli_close($conn);
            header("Location:./login.php?success=no");
            die();
        } else if (isset($_POST['create'])) {
            $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
            $adresse = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['adresse']));
            $tel = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['tel']));
            $prenom = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['prenom']));
            $nom = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['nom']));
            $password = hash("whirlpool", $_POST['password']);
            
            $query = "SELECT * FROM users WHERE email='" . $email . "'";
            $result = mysqli_query($conn, $query);
            if ($result !== false && mysqli_num_rows($result) > 0) {
                mysqli_close($conn);
                header("Location:./login.php?alreadyExists=yes");
                die();
            }

            $query = "INSERT INTO users (nom, prenom, email, pwd, tel, adresse)" .
                "VALUES ('" . $nom . "', '" . $prenom . "', '" .
                $email . "', '" . $password . "', '" . $tel . "', '" . $adresse . "')";
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                header("Location:./login.php?error=yes");
                die();
            }
        }
        mysqli_close($conn);
    }

    include("templates/header.php");
?>
<div class="milieu" style='text-align: left; font-family: verdana;'>
        <div class="accueil">
            <div class="split">
                <h2>Deja client</h2>
                    <form class="formaccount" action="login.php" method="post">
                    <label Class="label">Email : </label>
                    <input type="text" name="email" required>
                    <br>
                    <label Class="label">Mot de Passe : </label>
                    <input type="password" name="password" required>
                    <br>
                    <?php
                        if (isset($_GET['error']) && $_GET['error'] === "yes") {
                            echo "<p style='color: red;'>Erreur lors de la connexion.</p>";
                        } else if (isset($_GET['success']) && $_GET['success'] === "no") {
                            echo "<p style='color: red;'>Email inconnu.</p>";
                        }
                    ?>
                    <br>
                    <input type="submit" name="login" value="Se connecter">
                </form>
            </div>
            <div class="split">
                <h2>Creer un compte</h2>
                    <form class="formaccount" action="login.php" method="post">
                        <label Class="label">Nom : </label>
                        <input type="text" name="nom" required>
                        <br>
                        <label Class="label">Prénom : </label>
                        <input type="text" name="prenom" required>
                        <br>
                        <label Class="label">Email : </label>
                        <input type="email" name="email" required>
                        <br>
                        <label Class="label">Tel : </label>
                        <input type="text" name="tel" required>
                        <br>
                        <label Class="label">Mot de Passe </label>
                        <input type="password" name="password" required>
                        <br>
                        <label Class="label">Adresse : </label>
                        <input type="text" name="adresse" required>
                        <br>
                        <?php
                            if (isset($_GET['alreadyExists']) && $_GET['alreadyExists'] === "yes") {
                                echo "<p style='color: red;'>Un compte existe déjà avec cet email!</p>";
                            }
                        ?>
                        <br>
                        <input type="submit" name="create" value="Créer mon compte">
                    </form>
                </div>
            </div>
        </div>
</div>
<?php
    include("templates/footer.php");
?>