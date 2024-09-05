<?php

    session_start();

    $_SESSION['activo'] = 0;

    session_unset();
    session_destroy();

    header("Location: ../login.php");

?>