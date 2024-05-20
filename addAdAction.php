<?php
    //vključi povezavo do db
    include "db.php";
    include "userClass.php";

    session_start();
    //dobimo seznam cen iz baze
    $query = "SELECT * FROM price_ranges";
    $prices = $conn->query($query);

    //dobimo podatke iz obrazca
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $priceInput = $_POST["price"];
    $priceRange;
    $imageUrl = $_POST["imageUrl"];

    $userId = $_SESSION["user"]->id;

    //pretvorimo ceno v kategorijo
    //gremo skozi vse cenovne range in najdemo primernega

    while($price = $prices->fetch_assoc()){
        $currentPriceRange = explode('_', $price["value"]);

        if($priceInput >= $currentPriceRange[0] && ($priceInput <= $currentPriceRange[1] || $currentPriceRange[1] == '+')){
            $priceRange = $price["value"];
        }
    }

    //vstavimo v tabelo
    $query = "INSERT INTO ads(userId, brand, model, price, imageUrl) VALUES ('$userId', '$brand', '$model', '$priceRange', '$imageUrl')";
    $result = $conn->query($query);

    // če je bil INSERT uspešen, preusmerimo DOMOV
    if ($conn->affected_rows > 0) {
        header("Location: /?flag=addedPost");
        die();
    } else {
        echo "Error executing query: " . $conn->error;
        die();
    }
?>
