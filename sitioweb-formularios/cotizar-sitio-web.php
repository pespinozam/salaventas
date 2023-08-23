
<?php

$dateON= date("Y-m-d");
// echo($dateON);
$rut = $_POST['et_pb_contact_RUT_0'];
$correo = $_POST['et_pb_signup_email'];
$nombre = $_POST['et_pb_contact_NOMBRE_COMPLETO_0'];
$telefono = $_POST['et_pb_contact_TELEFONO_0'];
$proyecto = $_POST['et_pb_contact_PROYECTO_INMOBILIARIO_0'];

$fuente = "Sitio Web";

$authorization_token = "c688517e5411dbfb40d035d129c968dd071b227f";


$ArrayProjects = array(
    "BADEN32"=>1, 
    "TALAVERAS72"=>2,
    "EYZAGUIRRE72"=>3,
    "ECV103"=>4,
    "DELABARRA"=>5,
    "DELRIO30"=>6,
    
    "252MARATHON"=>8,
    "24CRISOSTOMO"=>9,
    "131WOOD"=>13,
    "42LINARES"=>14,
    "153SANCRISTOBAL"=>15,
    "273SANTIAGO"=>18
);

$ArrayStatus = array(
    "BADEN32"=>1, 
    "TALAVERAS72"=>8,
    "EYZAGUIRRE72"=>14,
    "ECV103"=>20,
    "DELABARRA"=>26,
    "DELRIO30"=>32,

    "252MARATHON"=>44,
    "24CRISOSTOMO"=>50,
    "131WOOD"=>75,
    "42LINARES"=>80,
    "153SANCRISTOBAL"=>89,
    "273SANTIAGO"=>106
);


$titulo = $nombre.'-'.$correo.'-'.$telefono;
$nombre_completo = $nombre;
$rutCliente = $rut;
$mail = $correo;
$telefonoCliente = $telefono;

$post = [
    "title" => $titulo,
    "value" => $nombre_completo,
    "currency" =>"CLP",
    "user_id" => "",
    "person_id" => "",
    "dfe9ae38b9a93c369148bd30a2c969ebd8a059f1" => $proyecto,
    "org_id" => $proyecto,
    "a053abef1b4aebceb9bb17de7d789fd9a5bf9b9f" => $fuente,
    "pipeline_id" => $ArrayProjects[strtoupper(trim($proyecto))],
    "stage_id" => $ArrayStatus[strtoupper(trim($proyecto))],
    "status" => "open",
    "expected_close_date" => "",
    "probability" => "",
    "lost_reason" => "",
    "visible_to" => "3",
    "add_time" => $dateON,
    "c993dded94c0982d52b9a140717b8a12fbe3ec72-add" => $proyecto,
    "ff3ab516bad04448ceb525b90cd45ec3cfcdceca" => $mail,
    "47434ac3577a44c41cbd4650b0185620f0b45310" => $telefonoCliente
];



$chAPI = curl_init('https://api.pipedrive.com/v1/deals?api_token='.$authorization_token);
curl_setopt($chAPI, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chAPI, CURLOPT_POSTFIELDS, http_build_query($post));

$result = curl_exec($chAPI);
curl_close($chAPI);

$resultPipedrive = json_decode($result);
var_dump($resultPipedrive->success);


