<?php

  require 'vendor/autoload.php';
  use Mailjet\Resources;
  $mj = new Mailjet\Client('13246da25960b191db9548ab13e1a009','3c19ab25a305c1410200b759dede4015',true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "contacto@surmonte.cl",
          'Name' => "Contacto"
        ],
        'To' => [
          [
            'Email' => "knubi01@gmail.com",
            'Name' => "patricio"
          ]
        ],
        'TemplateID' => 4978785,
        'TemplateLanguage' => true,
        'Subject' => "Contacto",
        'Variables' => json_decode('{
    "mensaje": "necesito info",
    "nombre": "patricio",
    "rut": "2342234",
    "email": "sdfsdfsd",
    "telefono": "23423432",
    "proyecto": "dfsdfsd"
  }', true)
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success() && var_dump($response->getData());
?>