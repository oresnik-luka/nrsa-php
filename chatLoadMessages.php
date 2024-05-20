<?php 
    include "db.php";
    include "userClass.php";
    session_start();

    header('Content-Type: application/json');

    $userId = $_SESSION["user"]->id;

    $query = "SELECT * FROM messages WHERE fromId = '$userId' OR toId = '$userId' ORDER BY date ASC";
    $result = $conn->query($query);

    $messages = array();
    while($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    $messages_json = json_encode($messages, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    echo $messages_json;
?>