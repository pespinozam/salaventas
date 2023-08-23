
<?php

require '../vendor/autoload.php';
use Mailjet\Resources;

$dateON= date("Y-m-d");
$rut = $_POST['et_pb_contact_RUT_0'];
$correo = $_POST['et_pb_signup_email'];
$nombre = $_POST['et_pb_contact_NOMBRE_COMPLETO_0'];
$telefono = $_POST['et_pb_contact_TELEFONO_0'];
$tipoConsulta = $_POST['et_pb_contact_TIPO_DE_CONSULTA_0'];
$mensaje = $_POST['et_pb_contact_COMENTARIOS_0'];

$fuente = "Sitio Web";

$authorization_token = "c688517e5411dbfb40d035d129c968dd071b227f";

$project_pipe = 27;
$project_status = 166;

if($tipoConsulta == 'Venta' || $tipoConsulta == 'Inversiones' ) {
    // $proyecto = $value['proyecto'];
    $titulo = $tipoConsulta.'-'.$nombre.'-'.$correo.'-'.$telefono;
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
        "dfe9ae38b9a93c369148bd30a2c969ebd8a059f1" => "",
        "org_id" => "",
        "a053abef1b4aebceb9bb17de7d789fd9a5bf9b9f" => $fuente,
        "pipeline_id" => $project_pipe,
        "stage_id" => $project_status,
        "status" => "open",
        "expected_close_date" => "",
        "probability" => "",
        "lost_reason" => "",
        "visible_to" => "3",
        "add_time" => $dateON,
        "c993dded94c0982d52b9a140717b8a12fbe3ec72-add" => "",
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
} 

if ($tipoConsulta == 'Postventa') {
    
    $mj = new Mailjet\Client('13246da25960b191db9548ab13e1a009','3c19ab25a305c1410200b759dede4015',true,['version' => 'v3.1']);
    $body = [
        'Messages' => [
        [
            'From' => [
            'Email' => "contacto@surmonte.cl",
            'Name' => "Sitio Web Surmonte"
            ],
            'To' => [
            [
                'Email' => "servicioalcliente@surmonte.cl",
                'Name' => "Servicio al Cliente"
            ]
            ],
            'TemplateID' => 4978785,
            'TemplateLanguage' => true,
            'Subject' => "Nueva Solicitud de PostVenta Sitio Web Surmonte - " . date("d-m-Y"),
            'Variables' => json_decode('{
        "mensaje": "' . $mensaje . '",
        "nombre": "' . $nombre . '",
        "rut": "' . $rut . '",
        "email": "' . $correo . '",
        "telefono": "' . $telefono . '",
        "proyecto": ""
    }', true)
        ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);

    var_dump($response->success());
    
}


