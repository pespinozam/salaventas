<?php
// require_once 'loginProceso.php';

session_start();

if(isset($_SESSION['nombre'])){
    session_destroy();
}

$llave = false;
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if($enlace_actual == 'http://localhost/salaventas/cerrar_sesion.php'){
    $llave = false;
}else{
    header("Location: https://salaventas.surmonte.cl/index.php");
    $llave = true;
}



