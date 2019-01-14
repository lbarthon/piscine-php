<?php
    include("checks.php");
        
    $conn = mysqli_connect($server, $username, $password, $db);
    if (!$conn) {
        die("SQL connection error: " . mysqli_connect_error());
    }

    if (isset($_POST) && (isset($_POST['submit']) && $_POST['submit'] === "OK") ||
            (isset($_POST['adduser']) && $_POST['adduser'] === "OK")) {
        if (isset($_POST['adduser']) && $_POST['adduser'] === "OK") {
            /**
             * Listens to add user form.
             */
            $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
            $adresse = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['adresse']));
            $tel = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['tel']));
            $isadmin = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['isadmin']));
            $name_array = explode(" ", $_POST['name']);
            $prenom = htmlspecialchars(mysqli_real_escape_string($conn, $name_array[0]));
            $nom = htmlspecialchars(mysqli_real_escape_string($conn, $name_array[1]));
            $password = hash("whirlpool", $_POST['password']);
            
            $query = "SELECT * FROM users WHERE email='" . $email . "'";
            $result = mysqli_query($conn, $query);
            if ($result !== false && mysqli_num_rows($result) > 0) {
                mysqli_close($conn);
                header("Location:./users.php?alreadyexists=yes");
                die();
            }

            $query = "INSERT INTO users (perm_level, nom, prenom, email, pwd, tel, adresse)" .
                "VALUES ('" . $isadmin . "', '" . $nom . "', '" . $prenom . "', '" .
                $email . "', '" . $password . "', '" . $tel . "', '" . $adresse . "')";
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
        }
        else if (isset($_POST['keep']) && $_POST['keep'] === "keep") {
            /**
             * Listens to edit user form.
             */
            $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
            $adresse = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['adresse']));
            $tel = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['tel']));
            $isadmin = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['isadmin']));
            $name_array = explode(" ", $_POST['name']);
            $prenom = htmlspecialchars(mysqli_real_escape_string($conn, $name_array[0]));
            $nom = htmlspecialchars(mysqli_real_escape_string($conn, $name_array[1]));
            $query = "UPDATE users SET email='" . $email .
                "', adresse='" . $adresse .
                "', tel='" . $tel .
                "', perm_level='" . $isadmin .
                "', nom='" . $nom .
                "', prenom='" . $prenom .
                "' WHERE id='" . $_POST['id'] . "'";
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
        } else {
            /**
             * Listens to delete user form.
             */
            $query = "DELETE FROM users WHERE id=" . $_POST['id'];
            if (!mysqli_query($conn, $query)) {
                mysqli_close($conn);
                die("Error on query '" . $query . "' " . mysqli_error($conn));
            }
        }
    }

    include("templates/header.php");

    $query = "SELECT * FROM users";
    $users = mysqli_query($conn, $query);

    echo "<div class='center'>";
    
    /**
     * Prints error if same email.
     */
    if (isset($_GET) && isset($_GET['alreadyexists']) && $_GET['alreadyexists'] === "yes") {
        echo "<p class='error'>Un utilisateur porte déjà cet email!<p>";
    }

    /**
     * Displays format of what'll be printed down.
     */
    echo "<ul class='userinfos'><li>Prénom Nom</li><li>Email</li><li>Adresse</li><li>Tel</li><li>Admin</li></ul>";

    if ($users && mysqli_num_rows($users) > 0) {
        /**
         * Displays all users in forms.
         */
        while ($user = mysqli_fetch_assoc($users)) {
            echo "<form action='users.php' class='userform' method='post'>";
            echo "<input class='nowidth' type='checkbox' name='keep' value='keep' title='Keep?' checked>";
            echo "<input type='hidden' name='id' value='" . $user['id'] . "'>";
            echo "<input type='text' name='name' value='". $user['prenom'] . " " . $user['nom'] . "' required>";
            echo "<input type='text' name='email' value='". $user['email'] . "' required>";
            echo "<input type='text' name='adresse' value='". $user['adresse'] . "' required>";
            echo "<input type='text' name='tel' value='". $user['tel'] . "' required>";
            echo "<input type='text' name='isadmin' value='". $user['perm_level'] . "' required>";
            echo "<input class='nowidth' type='submit' name='submit' value='OK'>";
            echo "</form>";
        }
    } else {
        echo "<h1 style='text-align:center;'>Error loading users...</h1>";
    }

    /**
     * Add user form.
     */
    echo "<br>";
    echo "<form action='users.php' class='adduserform' method='post'>";
    echo "Add user: <input type='text' name='name' placeholder='Prenom Nom' required>";
    echo "<input type='email' name='email' placeholder='Email' required>";
    echo "<input type='text' name='adresse' placeholder='Adresse' required>";
    echo "<input type='text' name='tel' placeholder='Téléphone' required>";
    echo "<input type='password' name='password' placeholder='Mot de passe' required>";
    echo "<input type='text' name='isadmin' placeholder='Admin' required>";
    echo "<input class='nowidth' type='submit' name='adduser' value='OK'>";
    echo "</form>";

    mysqli_close($conn);
    echo "</div>";

    include("templates/footer.php");
