<?php
    //activas depuración
    define("debugOn", 1);
    //desactivas depuración
    define("debugOff", 0);
    
    header('Content-Type: text/html; charset=UTF-8');
    //seccion requiere
    require_once "utils.php";
    require_once "config.php";
    require_once "db.php";
    require_once "validation.php";
    
    //seccion inicialización
    session_start();

?>

