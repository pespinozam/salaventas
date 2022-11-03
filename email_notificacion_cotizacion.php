<?php

require 'vendor/autoload.php';
use Mailjet\Resources;

$nombre_completo = $_POST['nombre_completo'];
$id_cotizacion = $_POST['id_cotizacion'];
$rut = $_POST['rut'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];

$pdf_path = "cotizaciones_clientes/".$rut."-".trim($id_cotizacion).".pdf";
$pdf_encode = base64_encode(file_get_contents($pdf_path));

  $mj = new Mailjet\Client('13246da25960b191db9548ab13e1a009', '3c19ab25a305c1410200b759dede4015', true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "contacto@surmonte.cl",
          'Name' => "Cotizacion Surmonte - ".$id_cotizacion
        ],
        'To' => [
          [
            'Email' => $email,
            'Name' => $nombre_completo
          ]
        ],
        'TemplateID' => 4160522,
        'TemplateLanguage' => true,
        'Subject' => "[COTIZACIÓN SURMONTE] N° ".$id_cotizacion,
        'Variables' => json_decode('{
            "nombre_completo": "'.$nombre_completo.'",
            "id_cotizacion": "'.$id_cotizacion.'",
            "rut": "'.$rut.'",
            "email": "'.$email.'",
            "telefono": "'.$telefono.'"
        }', true),
        'Attachments' => [
            [
                'ContentType' => "application/pdf",
                'Filename' => "Cotizacion".$id_cotizacion.".pdf",
                'Base64Content' => $pdf_encode
            ]
        ]
      ]
    ]
  ];

  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success() && var_dump($response->getData());

?>