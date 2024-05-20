<?php
    session_start();

    //odstranimo vse spremenljivke seje
    session_unset();

    //uničimo sejo
    session_destroy();

    header("Location: index.php");
?>