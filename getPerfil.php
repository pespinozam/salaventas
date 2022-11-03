<?php 

require_once 'includes/db.php';
// iniciar conexion
$db = new DB;

$rut = $_POST['rut'];

echo $rut;

// $ruta = array("nombre" => $nombre, "rut" => $rut, "correo" => $correo, "password" => $pass, "telefono" => $tel);


?>