<?php
    // vključi povezavo do db
    include "db.php";
    include "userClass.php";

    // get values from form
    $username = $_POST["inputUsername"];
    $password = $_POST["inputPassword"];

    // dobimo vrstico iz tabele `users`, kjer je username enak $username
    // sql SELECT statement
    $sql = "SELECT * FROM users WHERE username = '$username'";

    // execute the statement in database ($conn)
    $result = $conn->query($sql);

    // če je v rezultatu SELECT stavka natančno 1 zapis (vrstica, row), potem primerjamo geslo
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // decrypt password
        $verify = password_verify($password, $row["password"]);

        // če je geslo enako, nastavimo usera in preusmerimo nazaj DOMOV (index.php)
        if($verify){
            // začnemo session
            session_start();

            // nastavimo uporabnika v sessionu
            $_SESSION["user"] = new User($row["id"], $row["username"], $row["display_name"], $row["created"]);

            // preusmerimo DOMOV
            header("Location: index.php");
            die();
        }
        else {
            header("Location: login.php");
            die();
        }
    }
    else {
        header("Location: login.php");
        die();
    }
?>