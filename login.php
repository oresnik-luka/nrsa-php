<?php
    $title = "Prijava";

    include "header.php";
?>

<h1>Prijavi se v račun</h1>
<form action="loginAction.php" method="post" class="defaultForm">
    <label for="inputUsername">Uporabniško ime: </label>
    <input id="inputUsername" name="inputUsername" type="text"><br>

    <label for="inputPassword">Geslo: </label>
    <input id="inputPassword" name="inputPassword" type="password"><br>

    <button type="submit">Prijava</button>
</form>

<?php include "footer.php"; ?>