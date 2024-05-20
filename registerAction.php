<?php
    // vključi povezavo do db
    include 'db.php';

    // get values from form
    $username = $_POST["inputUsername"];
    $displayName = $_POST["inputDisplayName"];
    $password = $_POST["inputPassword"];

    // encrypt password
    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

    // insert data into database (table `users`)
    // sql INSERT statement
    $sql = "INSERT INTO users (username, display_name, password) VALUES ('$username', '$displayName', '$encryptedPassword')";

    // execute the statement in database ($conn)
    $result = $conn->query($sql);

    // če je bil INSERT uspešen, preusmerimo na /login.php
    if ($conn->affected_rows > 0) {
        header("Location: login.php");
        die();
    } else {
        echo "Error executing query: " . $conn->error;
        die();
    }
?>