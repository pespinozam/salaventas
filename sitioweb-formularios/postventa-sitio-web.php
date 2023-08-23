
<?php

require '../vendor/autoload.php';
use Mailjet\Resources;

$dateON= date("Y-m-d");
$rut = $_POST['et_pb_contact_7_0'];
$correo = $_POST['et_pb_signup_email'];
$nombre = $_POST['et_pb_contact_6_0'];
$telefono = $_POST['et_pb_contact_4_0'];
$proyecto = $_POST['et_pb_contact_8_0'];
$mensaje = $_POST['et_pb_contact_9_0'];
 
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
    "proyecto": "' . $proyecto . '"
}', true)
    ]
    ]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);

var_dump($response->success());



