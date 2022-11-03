<?php

require_once 'vendor/autoload.php';
require_once 'includes/db.php';
require_once 'includes/uf_methods.php';
require_once 'includes/valida_reserva.php';
use Transbank\Webpay\WebpayPlus\MallTransaction;
use Mailjet\Resources;

// Por simplicidad de este ejemplo, este es nuestro "controlador" que define que vamos a hacer dependiendo del parametro ?action= de la URL.
$action = $_GET['action'] ?? null;
if (!$action) {
    exit('Debe indicar la acción a realizar');
}

$hoy = date("Y-m-d");
$conexion = new DB;
$uf_actual = valida_uf();
/*
|--------------------------------------------------------------------------
| Crear transacción
|--------------------------------------------------------------------------
/ Apenas entramos esta página, con fines demostrativos,
*/
if ($_GET['action'] === 'create') {
    $commerceCode = "597042343492"; 
    $apiKeySecret = "d00cd7b1b6216678aad75af0ddd74108";
    $transaction = (new Transbank\Webpay\WebpayPlus\MallTransaction)->configureForProduction($commerceCode, $apiKeySecret);
    $proyecto = trim($_POST["proyecto"]);
    $id_cotizacion = $_POST["cotizacion"];
    $rut = $_POST["rut"];
    $id_prod = $_POST["id_prod"];
    $precios_prod = $_POST["precios_prod"];
    $rut_limpio = str_replace(".","",$rut);
    $buy_order = $proyecto."-".$id_cotizacion;

    $nombre = explode(" ",$_POST["nombre_completo"]);
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $telefono_limpio = str_replace("+","",$telefono);

    $sql = "SELECT * FROM business_code WHERE proyecto = :proy";
    $consulta = $conexion->connect()->prepare($sql);
    $consulta->bindParam(":proy", $proyecto, PDO::PARAM_STR);
    $consulta->execute();
    
    $res = $consulta->fetch(PDO::FETCH_ASSOC);

    $transaction_details = [                                          
        [
            "amount" => 500,
            
            "commerce_code" => (int) $res['bc'],
            "buy_order" => $id_cotizacion."-".$proyecto
        ]
    ];
    
    $url = "https://salaventas.surmonte.cl/transaction.php?action=result&rut=".$rut_limpio."&id_cotizacion=".$id_cotizacion."&id_producto=".implode($id_prod)."&precios_producto=".implode($precios_prod)."&proyecto=".$proyecto."&nombre=".$nombre[0]."&telefono=".$telefono_limpio."&correo=".$correo."";

    $createResponse = $transaction->create($id_cotizacion."-".$proyecto, uniqid(),"https://salaventas.surmonte.cl/transaction.php?action=result&rut=".$rut_limpio."&id_cotizacion=".$id_cotizacion."&id_producto=".implode($id_prod)."&precios_producto=".implode($precios_prod)."&proyecto=".$proyecto."&nombre=".$nombre[0]."&telefono=".$telefono_limpio."&correo=".$correo."", $transaction_details);
    $token = $createResponse->getToken();
    $url = $createResponse->getUrl();

    // Acá guardar el token recibido ($createResponse->getToken()) en tu base de datos asociado a la orden o
    // lo que se esté pagando en tu sistema

    //Redirigimos al formulario de Webpay por GET, enviando a la URL recibida con el token recibido.
    $redirectUrl = $url.'?token_ws='.$token;
    header('Location: '.$redirectUrl, true, 302);
    exit;
    
}

/*
|--------------------------------------------------------------------------
| Confirmar transacción
|--------------------------------------------------------------------------
/ Esto se debería ejecutar cuando el usario finaliza el proceso de pago en el formulario de webpay.
*/
if ($_GET['action'] === 'result') {

    if (userAbortedOnWebpayForm()) {
        cancelOrder();
        exit();
    }
    if (anErrorOcurredOnWebpayForm()) {
        cancelOrder();
        exit();
    }
    if (theUserWasRedirectedBecauseWasIdleFor10MinutesOnWebapayForm()) {
        cancelOrder();
        exit();
    }
    //Por último, verificamos que solo tengamos un token_ws. Si no es así, es porque algo extraño ocurre.
    if (!isANormalPaymentFlow()) { // Notar que dice ! al principio.
        cancelOrder();
        exit();
    }
    
    $commerceCode = "597042343492";
    $apiKeySecret = "d00cd7b1b6216678aad75af0ddd74108";
    $transaction = (new Transbank\Webpay\WebpayPlus\MallTransaction)->configureForProduction($commerceCode, $apiKeySecret);
  
    // Acá ya estamos seguros de que tenemos un flujo de pago normal. Si no, habría "muerto" en los checks anteriores.
    $token = $_GET['token_ws'] ?? $_GET['token_ws'] ?? null; // Obtener el token de un flujo normal
    $response = $transaction->commit($token);
      
    if ($response->isApproved()) {
        //Si el pago está aprobado (responseCode == 0 && status === 'AUTHORIZED') entonces aprobamos nuestra compra
        // Código para aprobar compra acá
        $valida_reserva = valida_reserva_cotizacion($_GET['id_cotizacion'] ?? $_GET['id_cotizacion'] ?? null);
        if (!($valida_reserva)) {

          $rut = $_GET['rut'] ?? $_GET['rut'] ?? null;
          $nombre = $_GET['nombre'] ?? $_GET['nombre'] ?? null;
          $telefono = $_GET['telefono'] ?? $_GET['telefono'] ?? null;
          $correo = $_GET['correo'] ?? $_GET['correo'] ?? null;
          $id_cotizacion = $_GET['id_cotizacion'] ?? $_GET['id_cotizacion'] ?? null;
          $proyecto = $_GET['proyecto'] ?? $_GET['proyecto'] ?? null;
          
          $id_producto = $_GET['id_producto'] ?? $_GET['id_producto'] ?? null;
          $precios_prod = $_GET['precios_producto'] ?? $_GET['precios_producto'] ?? null;
          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.surmonte.cl/v1/reservas',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'
            {
            "fecRes": "'.$hoy.'",
            "idCot": "'.$id_cotizacion.'",
            "rutCli": "'.$rut.'"
            }',
            CURLOPT_HTTPHEADER => array(
              'Authorization: Basic YXBpc3VybW9udGU6QVBJMjAyMV9zbW50',
              'Content-Type: application/json'
            ),
          ));

          $res = curl_exec($curl);
          curl_close($curl);
          $json_response = json_decode($res, true);
          $id_reserva = $json_response["idReserva"];
          $productos = explode(" ", trim($id_producto) );
          $precios = trim(str_replace('UF', '', $precios_prod));
          $precios_clean = array_diff(explode(" ", $precios), array(""));
        
          $precios_finally = array();
          foreach ($precios_clean as $pre) {
            array_push($precios_finally, $pre);
          }
          $count_productos = count($productos);
          $count_precios = count($precios_finally); 

          if($count_productos == $count_precios)
          {

            for ($i=0; $i < $count_productos; $i++) { 
              
              $curl = curl_init();
              //Cliente post
              $post1 = [
                "idCotizacion" => $id_cotizacion,
                "idProducto" => $productos[$i],
                "proyecto" => $proyecto,
                "precio" => $precios_finally[$i],
                "precioD" => 0
              ];

              $login = 'apisurmonte';
              $password = 'API2021_smnt';

              $ch = curl_init('https://api.surmonte.cl/v1/reservas/'.$id_reserva.'/detalle');
              curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
              curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post1));
          
              $res = curl_exec($ch);
              curl_close($ch);
            }

              $curl = curl_init();

              curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.surmonte.cl/v1/pagos',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'
              {
                "origenPago": "reserva",
                "productoId": "'.$productos[0].'",
                "monto": 150000,
                "idOrigen": '.$id_reserva.',
                "montoUf": '.$uf_actual.',
                "fechaPago": "'.$hoy.'",
                "numTransf": 123456
              }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YXBpc3VybW9udGU6QVBJMjAyMV9zbW50',
                'Content-Type: application/json'
              ),
            ));
        
            $res = curl_exec($curl);
            curl_close($curl);

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
                      'Email' => $correo,
                      'Name' => $nombre
                    ],
                    [
                      'Email' => "jramirez@surmonte.cl",
                      'Name' => "Javier Ramirez"
                    ],
                  ],
                  'TemplateID' => 4195355,
                  'TemplateLanguage' => true,
                  'Subject' => "[CLIENTE SURMONTE] Reserva N°".$id_reserva,
                  'Variables' => json_decode('{
                  "nombre_completo": "'.$nombre.'",
                  "id_reserva": "'.$id_reserva.'",
                  "email": "'.$correo.'",
                  "telefono": "'.$telefono.'"
                  }', true)
                ]
              ]
            ];
          
            $r = $mj->post(Resources::$Email, ['body' => $body]);
            $r->success();

          }
        }else{
          header('Location: index.php');
        }
        
        approveOrder($response);

        // $mpdf = new \Mpdf\Mpdf();
        // $mpdf->WriteHTML(approveOrder($response));
        // $mpdf->Output("Comprobante.pdf","D");
  
    } else {

        cancelOrder();
    }
    
    return;
}

function cancelOrder($response = null)
{
    // Acá has lo que tangas que hacer para marcar la orden como fallida o cancelada
    if ($response) {
        echo '<pre>'.print_r($response, true).'</pre>';
    }

    $html = '<!DOCTYPE html>
    <html>
    <head>
    <title>Reserva - Rechazada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="shB284-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>
    <body style="background-color: black; font-family: "Lato", sans-serif;" >
    <br>
    <div style="background-color: white; border-radius: 10px; padding: 40px;" class="container">
    <div class="row">
        <div class="col-md-12">
        <center><img width="300" src="assets/surmonte-logo-1.png"></img></center>
        </div>
      </div>
      <br>
      <br>
      <div class="row">
        <div class="col-md-12">
        <center><h1>Reserva <strong>¡Rechazada!</strong></h1></center>
        </div>
      </div>
      <div class="row" style="padding: 40px; border: 1px solid #fcb900;">
        <div class="col-md-12">
            <center><img width="150" src="assets/error.png"></img></center>
        </div>
        <div class="col-md-12">
        </div>
        <br>
        <hr>
        <center>
          <div class="d-grid">
              <a href="https://surmonte.cl" class="btn btn-primary btn-block">Ir al comercio</a>
           </div>
        </center>
      </div>
    <br>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://kit.fontawesome.com/f5939545a8.js" crossorigin="anonymous"></script>
    </body>
    </html>';

    echo $html;
}

function approveOrder($response)
{
 
$details = $response->getDetails();

$html = '<!DOCTYPE html>
<html>
<head>
<title>Reserva - Pagado</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="shB284-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<link href="http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body style="background-color: white; font-family: Lato;>
<br>
<div style="background-color: white; padding: 40px; border: 1px solid black; " class="container">
<div class="row d-flex d-flex p-2">
  <div class="col-12 col-md-12 d-flex justify-content-center p-4" style="background-color: black; color:white;">
    <img width="350" src="assets/Logo_surmonte_2.png"></img>
  </div>
</div>
  <br>
  <br>
  <div class="row">
  
    <div class="col-md-12">
    <center><h1>¡Gracias por reservar tu <strong> Surmonte</strong>!</h1></center>
    <br>
    <div class="col-md-12">
  <center><img width="100" src="assets/aprobado.png"></img></center>
  </div>
  <br>
    <center><h3>¡Agradecemos tu preferencia por nosotros!</h3></center>
    </div>
  </div>
  <br>
  <div class="row" style="padding: 40px; border: 1px solid black;">
    <div class="col-md-12">
      <center><strong><h2></strong></h2></center>
    </div>
    <div class="col-md-12">
    <table class="table">
      <thead class="thead dark">
        <tr>
          <th scope="col">Concepto</th>
          <th scope="col">Detalle</th>
        </tr>
      </thead>
       <tbody>';
       foreach($details as $detail){
        $html .= '
          <tr>
            <td>Monto pagado </td>
            <td>$'.number_format($detail->getAmount(),0,',','.' ).'</td>
          </tr>
          <tr>
          <td>Código Autorización</td>
          <td>'.$detail->getAuthorizationCode().'</td>
          </tr>
          <tr>
            <td>Orden: </td>
            <td>'.$detail->getBuyOrder().'</td>
          </tr>
          <tr>
            <td>Código comercio: </td>
            <td>'.$detail->getCommerceCode().'</td>
          </tr>
          <tr>
            <td>Cuotas: </td>
            <td>'.$detail->getInstallmentsNumber().'</td>
          </tr>
          <tr>
            <td>Código de pago: </td>
            <td>'.$detail->getPaymentTypeCode().'</td>
          </tr>
          <tr>
            <td>Respuesta: </td>
            <td>'.$detail->getResponseCode().'</td>
          </tr>
          <tr>
            <td>Estado: </td>
            <td>'.$detail->getStatus().'</td>
          </tr>
          <tr>
            <td>Aprobación: </td>
            <td>'.$detail->isApproved().'</td>
          </tr>';
       }
      $html .= ' 
       </tbody>
    </table>
    </div>
    <br>
    <hr>
    <center>
    <div class="d-grid gap-3">
    <form action="comprobante.php" method="POST">';
      foreach($details as $val){
      $html .= '
      <input type="hidden" name="result" value="'.number_format($val->getAmount(),0,',','.' )."|".$val->getAuthorizationCode()."|".$val->getBuyOrder()."|".$val->getInstallmentsNumber()."|".$val->getStatus()."|".$detail->isApproved().'">';
      }
      $html .= '
      <br><a href="https://surmonte.cl" class="btn btn-dark btn-lg pd-1 pt-1 m-1">Ir a surmonte.cl</a>
      <br><a href="https://salaventas.surmonte.cl/" class="btn btn-dark btn-lg pd-1 pt-1 m-1">Ir a flujocompra.cl</a>
      <br><a href="https://salaventas.surmonte.cl/home.php" class="btn btn-dark btn-lg pd-1 pt-1 m-1">Ir a portalclientes.cl</a>
      <br><br><button type="submit" class="btn btn-dark btn-lg">Descarga comprobante</button>
      </form>
      <div class="row">
      <div class="col-12 col-md-12 mb-5 text-justify">
      <small> Nos pondremos en contacto contigo a través de tu correo electrónico o teléfono para gestionar y acompañarte en el proceso de compra de tu <b>Surmonte</b>.  Si tienes dudas, contáctanos  al teléfono  <a href="tel: +56223078877">+562 2307887</a> o al correo <b> <a href="mailto:bsaavedra@surmonte.cl">bsaavedra@surmonte.cl</a>.</small>
      </div>
    </div>
     </div>
    </center>
  </div>
  <br>
  <div class="row">
  </div>
<br>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://kit.fontawesome.com/f5939545a8.js" crossorigin="anonymous"></script>
</body>
</html>';

echo $html;

}

function userAbortedOnWebpayForm()
{
    $tokenWs = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
    $tbkToken = $_GET['TBK_TOKEN'] ?? $_POST['TBK_TOKEN'] ?? null;
    $ordenCompra = $_GET['TBK_ORDEN_COMPRA'] ?? $_POST['TBK_ORDEN_COMPRA'] ?? null;
    $idSesion = $_GET['TBK_ID_SESION'] ?? $_POST['TBK_ID_SESION'] ?? null;

    // Si viene TBK_TOKEN, TBK_ORDEN_COMPRA y TBK_ID_SESION es porque el usuario abortó el pago
    return $tbkToken && $ordenCompra && $idSesion && !$tokenWs;
}

function anErrorOcurredOnWebpayForm()
{
    $tokenWs = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
    $tbkToken = $_GET['TBK_TOKEN'] ?? $_POST['TBK_TOKEN'] ?? null;
    $ordenCompra = $_GET['TBK_ORDEN_COMPRA'] ?? $_POST['TBK_ORDEN_COMPRA'] ?? null;
    $idSesion = $_GET['TBK_ID_SESION'] ?? $_POST['TBK_ID_SESION'] ?? null;

    // Si viene token_ws, TBK_TOKEN, TBK_ORDEN_COMPRA y TBK_ID_SESION es porque ocurrió un error en el formulario de pago
    return $tokenWs && $ordenCompra && $idSesion && $tbkToken;
}

function theUserWasRedirectedBecauseWasIdleFor10MinutesOnWebapayForm()
{
    $tokenWs = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
    $tbkToken = $_GET['TBK_TOKEN'] ?? $_POST['TBK_TOKEN'] ?? null;
    $ordenCompra = $_GET['TBK_ORDEN_COMPRA'] ?? $_POST['TBK_ORDEN_COMPRA'] ?? null;
    $idSesion = $_GET['TBK_ID_SESION'] ?? $_POST['TBK_ID_SESION'] ?? null;

    // Si viene solo TBK_ORDEN_COMPRA y TBK_ID_SESION es porque el usuario estuvo 10 minutos sin hacer nada en el
    // formulario de pago y se canceló la transacción automáticamente (por timeout)
    return $ordenCompra && $idSesion && !$tokenWs && !$tbkToken;
}

function isANormalPaymentFlow()
{
    $tokenWs = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
    $tbkToken = $_GET['TBK_TOKEN'] ?? $_POST['TBK_TOKEN'] ?? null;
    $ordenCompra = $_GET['TBK_ORDEN_COMPRA'] ?? $_POST['TBK_ORDEN_COMPRA'] ?? null;
    $idSesion = $_GET['TBK_ID_SESION'] ?? $_POST['TBK_ID_SESION'] ?? null;

    // Si viene solo token_ws es porque es un flujo de pago normal
    return $tokenWs && !$ordenCompra && !$idSesion && !$tbkToken;
}