<?php 


$dateON= date("Y-m-d");

$keyProyecto = '5c9bbab08e2348b88aa09ec8bf009822';
$keyOrigen = 'cf4c7d07e9d6447888fde751abb151dc';
$fecha = $dateON;

$keyString = 'kmK1u7mjAxcRpLtxStzHNfmaduo2dxH8';

$cadena = $keyProyecto . $keyOrigen . $fecha;
$string = '';
$pattern = "/[^a-zA-Z0-9]/";
$cadena = preg_replace($pattern, '', $cadena);    
//codigo
// echo '1) Esta es la cadena con expresion regular: '.$cadena;
// echo '<br>';


//codigo
$cadena = strtolower($cadena);
// echo '2) Esta es la cadena con ToLower: '.$cadena;
// echo '<br>';

// Encode a string to URL-safe base64
function encodeBase64UrlSafe($value)
{
  return str_replace(array('+', '/'), array('-', '_'),
    base64_encode($value));
}

// Decode a string from URL-safe base64
function decodeBase64UrlSafe($value)
{
  return base64_decode(str_replace(array('-', '_'), array('+', '/'),
    $value));
}

// Sign a URL with a given crypto key
// Note that this URL must be properly URL-encoded
function signUrl($myUrlToSign, $privateKey)
{
  // parse the url
  // $url = parse_url($myUrlToSign);

  // Decode the private key into its binary format
  $decodedKey = decodeBase64UrlSafe($privateKey);

  // Create a signature using the private key and the URL-encoded
  // string using HMAC SHA1. This signature will be binary.
  $signature = hash_hmac("sha1",$myUrlToSign, $decodedKey,  true);

  $encodedSignature = encodeBase64UrlSafe($signature);

  return $encodedSignature;
}


 

$firma = signUrl($cadena, $keyString);

// echo $firma.'<br>';

$params = array(

    "KeyProyecto" => $keyProyecto,
    "KeyOrigen" => $keyOrigen,
    "Fecha" => $fecha,
    "Firma" => $firma
);



// var_dump($params);
$fields_string = http_build_query($params);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://apirecolectorsolicitudes.addinmobiliario.cl/DatosContactos/');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// Cierra el gestor
curl_close($ch);

$array_api = json_decode($response, true);

var_dump($array_api);

$fuente = "Toc Toc";

 $authorization_token = "c688517e5411dbfb40d035d129c968dd071b227f";

 $project_pipe = 8;
 $project_status = 44;


 if($array_api['Message']){
    $msg = "No se encontraron registros para los parametros enviados. 252MARATHON";
    echo '<br>'.$msg.'<br>';
 }else{
    foreach ($array_api as $value){

        $proyecto = $value['proyecto'];
        $titulo = $value['nombre'].'-'.$value['email'].'-'.$value['telefono'];
        $nombre_completo = $value['nombre'];
        $array_name = explode(' ',$value['nombre']);
        $name = $array_name[0];
        $rutCliente = $value['rut'];
        $mail = $value['email'];
        $telefonoCliente = $value['telefono'];
    
        $post2 = [
                    "title" => $titulo,
                    "value" => $nombre_completo,
                    "currency" =>"CLP",
                    "user_id" => "",
                    "person_id" => "",
                    "dfe9ae38b9a93c369148bd30a2c969ebd8a059f1" => $proyecto,
                    "org_id" => $proyecto,
                    "a053abef1b4aebceb9bb17de7d789fd9a5bf9b9f" => $fuente,
                    "pipeline_id" => $project_pipe,
                    "stage_id" => $project_status,
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
                // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($chAPI, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chAPI, CURLOPT_POSTFIELDS, http_build_query($post2));
                
                $result = curl_exec($chAPI);
                curl_close($chAPI);
                echo $result;
        // echo '<br>'.$rutCliente;
    
     }
 }
 



?>