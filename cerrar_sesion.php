<?php
// require_once 'loginProceso.php';

session_start();

if(isset($_SESSION['nombre'])){
    session_destroy();
}

header("Location: https://salaventas.surmonte.cl/index.php");