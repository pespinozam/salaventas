<?php
//iniciar la sesión y la conexión a bd
require 'includes/db.php';
require 'vendor/autoload.php';

use Mailjet\Resources;

$password_random = random_int(10000, 99999);

$opciones = [
  'cost' => 12,
];

$password_random_hash = password_hash($password_random, PASSWORD_BCRYPT, $opciones);


$nombre_completo = $_POST['nombre_completo'];
$rut = str_replace('.','',$_POST['rut']);
$email = $_POST['email'];
$telefono = $_POST['telefono'];

// iniciar conexion
$conexion = new DB;

$sql = "SELECT * FROM auth_usuarios WHERE rut = :rut;";
$consulta = $conexion->connect()->prepare($sql);
$consulta->bindValue(":rut", $rut, PDO::PARAM_STR);
$consulta->execute();
$response = $consulta->fetch(PDO::FETCH_ASSOC);

if(!$response){

  $mj = new Mailjet\Client('13246da25960b191db9548ab13e1a009', '3c19ab25a305c1410200b759dede4015',true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "contacto@surmonte.cl",
          'Name' => "Surmonte Area Clientes"
        ],
        'To' => [
          [
            'Email' => $email,
            'Name' => $nombre_completo
          ]
        ],
        'TemplateID' => 4160358,
        'TemplateLanguage' => true,
        'Subject' => "[CLIENTE SURMONTE] Portal clientes",
        'Variables' => json_decode('{
        "rut_cliente": "'.$rut.'",
        "nombre_completo": "'.$nombre_completo.'",
        "password": "'.$password_random.'"
        }', true)
      ]
    ]
  ];

  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success();

    $sql = "INSERT INTO auth_usuarios (correo, telefono, nombre, rut, password, created_at, updated_at) VALUES (:correo, :telefono, :nombre, :rut, :pass, NOW(), NOW());";
   
    $consulta = $conexion->connect()->prepare($sql);
    $consulta->bindParam(":correo", $email, PDO::PARAM_STR);
    $consulta->bindParam(":telefono", $telefono, PDO::PARAM_STR);
    $consulta->bindParam(":nombre", $nombre_completo, PDO::PARAM_STR);
    $consulta->bindParam(":rut", $rut, PDO::PARAM_STR);
    $consulta->bindParam(":pass", $password_random_hash, PDO::PARAM_STR);
    $consulta->execute();
    
    $response = $consulta->fetch(PDO::FETCH_ASSOC);

}else{

    $response = array("status" => "existe");
    echo json_encode($response);

}




 

?>