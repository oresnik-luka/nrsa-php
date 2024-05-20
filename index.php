<?php
    include "userClass.php";
    session_start();
    $title = "Autoscout";
    include "header.php";
    include "db.php";

    //dobimo seznam znamk iz baze
    $query = "SELECT * FROM car_brands";
    $brands = $conn->query($query);

    $query = "SELECT * FROM price_ranges";
    $ranges = $conn->query($query);

    // preverimo flag (npr če je uporabnik ravnokar dodal oglas)
    $flag = "";
    if(isset($_REQUEST["flag"])){
       $flag = $_REQUEST["flag"];
    }
?>

<?php
    if($flag == "addedPost"){
        echo '<div class="addedAd">';
        echo 'Oglas uspešno objavljen!';
        echo '</div>';
    }
?>

<form action="index.php" method="get" id="search">
    <table>
        <tr>
            <td>
                <select name="brand" req>
                    <option value="default">Znamka</option>
                        <?php
                            while($brand = $brands->fetch_assoc()){
                                echo '<option value="' . $brand["name"] . '">' . $brand["displayname"] . '</option>';
                            }
                        ?>   
                </select>
            </td>
            <td>
                <select name="price" req>
                    <option value="default">Cena</option>
                    <?php
                        while($range = $ranges->fetch_assoc()){
                            echo '<option value="' . $range["value"] . '">' . $range["display_name"] . '</option>';
                        }
                    ?>
                </select>
            </td>
            <td>
                <button type="submit" class="searchBtn">
                    Najdi
                </button>
            </td>
        </tr>
    </table>
</form>

<div class="ads">
<?php if(!empty($_GET) && count($_GET) == 2){
        $brand = $_GET["brand"];
        $priceRange = $_GET["price"];

        $currentPriceRange = explode('_', $priceRange);

        $query = "SELECT * FROM ads WHERE brand = '$brand' AND price >= '$currentPriceRange[0]' AND (price <= '$currentPriceRange[1]' OR '$currentPriceRange[1]' = '+')";
    }
    else{
        $query = "SELECT * FROM ads ORDER BY created DESC LIMIT 5";
        $ads = $conn->query($query);
    }
        $ads = $conn->query($query);

        while($ad = $ads->fetch_assoc()){
            $formattedDate = new DateTimeImmutable($ad["created"]);
            $formattedDate = $formattedDate->format("d.m.Y");

            $userId = $ad["userId"];
            $query = "SELECT * FROM users WHERE id = '$userId'";
            $user = $conn->query($query);
            $user = $user->fetch_assoc();

            echo '<div class="ad">';
            echo '<div class="info">';
            echo '<div class="created">' . $formattedDate . '</div>'; ?>
            <a href="chat.php?user=<?php echo $user["id"]; ?>"><div class="user"><?php echo $user["display_name"]; ?><img src="chat_icon.svg"></div></a>
            <?php
            echo '</div>';
            echo '<div class="carinfo">';
            echo '<div class="brand">' . $ad["brand"] . '</div>';
            echo '<div class="model">' . $ad["model"] . '</div>';
            echo '</div>';
            echo '<div class="price">' . $ad["price"] . ' €</div>';
            echo '<div class="img"><img src="' . $ad["imageUrl"] . '"></div>';
            echo '</div>';
        }
?>
</div>

<?php include "footer.php"; ?>