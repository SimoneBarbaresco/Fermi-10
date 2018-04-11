<?php
    session_destroy();
    session_start();
    $_SESSION['log']= false;
    header("Location: ./index.php");
?>