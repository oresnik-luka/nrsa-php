<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <div class="header">
            <h3 ><a href="/">Autoscout</a></h3>

            <div class="navButtons">
            <?php
                //če uporabnik ni prijavljen
                if(!isset($_SESSION["user"])){
                    echo '<a href="login.php" ';
                    if($_SERVER["REQUEST_URI"] == "/login.php") echo "class='active'";
                    echo '>Prijava</a>';
                    echo '<a href="register.php" ';
                    if($_SERVER["REQUEST_URI"] == "/register.php") echo "class='active'";
                    echo '>Registracija</a>';
                }
                //če je uporabnik prijavljen
                else{
                    echo '<a class="add" href="addAd.php">';
                    echo '<span>+</span>';
                    echo '</a>';

                    echo '<div class="user">';
                    echo '<img src="/user_icon.svg">';
                    echo '<span>' . $_SESSION["user"]->displayName . '</span>';
                    echo '</div>';
                    echo '<a href="chat.php">';
                    echo '<div class="chatBtn">';
                    echo '<img src="/chat_icon.svg">Sporočila';
                    echo '</div>';
                    echo '</a>';
                    echo '<a href="logoutAction.php">Odjava</a>';
                }
            ?>
            </div>
        </div>
        <div class="content">