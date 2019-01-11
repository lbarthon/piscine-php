<?php
    if (isset($_SERVER['PHP_AUTH_USER']) !== false && isset($_SERVER['PHP_AUTH_PW']) !== false) {
        if ($_SERVER['PHP_AUTH_USER'] === "zaz" && $_SERVER['PHP_AUTH_PW'] === "jaimelespetitsponeys") {
            echo "<!DOCTYPE html><html><body>
                Bonjour Zaz<br />
                <img src='data:image/png;base64," . base64_encode(file_get_contents("../img/42.png")) . "'>
                </body></html>";
            return;
        }
    }
    header('WWW-Authenticate: Basic realm="Espace membres"');
    header('HTTP/1.0 401 Unauthorized');
    echo "<!DOCTYPE html><html><body>Cette zone est accessible uniquement aux membres du site</body></html>";
