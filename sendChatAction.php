<?php
    //vključi povezavo do db
    include "db.php";
    include "userClass.php";

    session_start();

    //dobimo podatke iz obrazca
    $target = $_POST["target"];
    $message = $_POST["message"];

    $userId = $_SESSION["user"]->id;

    $query = "INSERT INTO messages (fromId, toId, content) VALUES ('$userId', '$target', '$message')";
    $conn->query($query);
?>
