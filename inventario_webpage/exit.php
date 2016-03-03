<?php

    require_once "ini.php";
    check_session();

    session_destroy();

    redirect("index.php");

?>

