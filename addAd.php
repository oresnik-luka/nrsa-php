<?php
    include "userClass.php";
    session_start();
    $title = "Dodaj Oglas";
    include "header.php";
    include "db.php";

    $query = "SELECT * FROM car_brands";
    $brands = $conn->query($query);

?>

<form action="addAdAction.php" method="post" id="addAdFrom" class="defaultForm">
    <label for="brand">Znamka</label>
    <select name="brand" req>
        <option value="default">Znamka</option>
        <?php
            while($brand = $brands->fetch_assoc()){
                echo '<option value="' . $brand["name"] . '">' . $brand["displayname"] . '</option>';
            }
        ?>   
    </select><br>

    <label for="model">Model</label>
    <input type="text" name="model"><br>
    
    <label for="price">Cena</label>
    <input type="number" name="price"><br>

    <label for="imageUrl">Slika</label>
    <input type="text" name="imageUrl"><br>    

    <button type="submit">Objavi</button>

</form>

<?php include "footer.php"; ?>