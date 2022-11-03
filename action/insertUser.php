<?php 
//iniciar la sesión y la conexión a bd
require_once 'includes/db.php';

// iniciar conexion
$db = new DB;

$sql = "SELECT * FROM auth_usuarios WHERE rut = :rut;";
$consulta = $DB->connect()->prepare($sql);
$consulta->bindValue(":rut", $nombre, PDO::PARAM_STR);
$consulta->execute();
$response = $consulta->fetch(PDO::FETCH_ASSOC);

echo $response;

?>