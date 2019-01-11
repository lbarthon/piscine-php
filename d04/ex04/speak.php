<?php
    session_start();
    date_default_timezone_set("CET");
    if (isset($_POST) && isset($_POST['msg']) && isset($_POST['submit']) && isset($_SESSION['loggued_on_user'])) {
        if ($_POST['submit'] === "OK" && $_POST['msg'] !== "") {
            $user = $_SESSION['loggued_on_user'];
            $msg = $_POST['msg'];
            if (!file_exists("../private/chat")) {
                file_put_contents("../private/chat", "");
                $chat = array();
                $file = fopen("../private/chat", "rw");
                flock($file, LOCK_EX);
            } else {
                $chat = unserialize(file_get_contents("../private/chat"));
                $file = fopen("../private/chat", "rw");
                flock($file, LOCK_EX);
            }
            $chat[] = array(
                "login"=>$user,
                "time"=>time(),
                "msg"=>$msg
            );
            file_put_contents("../private/chat", serialize($chat));
            fclose($file);
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
    </head>
    <body>
        <form action="speak.php" method="post">
            <input type="text" name="msg" style="width: 100%;">
            <input type="submit" name="submit" value="OK">
        </form>
    </body>
</html>