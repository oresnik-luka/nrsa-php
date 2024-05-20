<?php
    $title = "Registracija";

    include "header.php";
?>

<h1>Registriraj novi račun</h1>
<form action="registerAction.php" method="post" class="defaultForm">
    <label for="inputUsername">Uporabniško ime: </label>
    <input id="inputUsername" name="inputUsername" type="text"><br>

    <label for="inputDisplayName">Ime: </label>
    <input id="inputDisplayName" name="inputDisplayName" type="text"><br>

    <label for="inputPassword">Geslo: </label>
    <input id="inputPassword" name="inputPassword" type="password"><br>

    <button type="submit">Registracija</button>
</form>

<?php include "footer.php"; ?>