<?php

use function PHPSTORM_META\type;
// date_default_timezone_set('America/Santiago');
date_default_timezone_set('UTC');
function get_access_token(){
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://public-api.yapo.cl/lead-public/api/v1/login/',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'username=privas%40surmonte.cl&password=QdtE5ppna%26MXNwp%2B',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    
    $get_response_array = json_decode($response, true);
    
    $get_data_response = $get_response_array['data'];
    $get_token_response = $get_data_response['access_token'];
    
    return $get_token_response;
}

function get_page_leads($access_token){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://public-api.yapo.cl/lead-public/api/v1/users/leads/1',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $access_token
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $get_response_array = json_decode($response, true);
    
    $get_data_response = $get_response_array['data'];
    // $get_total_pages_response = $get_data_response['total_pages'];
    
    return $get_data_response;
}

function get_leads($access_token, $page){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://public-api.yapo.cl/lead-public/api/v1/users/leads/' . (String) $page,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $access_token
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $get_response_array = json_decode($response, true);
    
    $get_data_response = $get_response_array['data'];
    $get_leads_response = $get_data_response['leads'];
    
    return $get_leads_response;
}


$access_token = (String) get_access_token();
$info_leads = get_page_leads($access_token);
$pages = $info_leads['total_pages'];
$count_leads = $info_leads['count'];

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

$leads_ids = array(
    // ""=>"BADEN32", 
    "177"=>"TALAVERAS72",
    // ""=>"EYZAGUIRRE72",
    "176"=>"ECV103",
    // ""=>"DELABARRA",
    // ""=>"DELRIO30",
    "174"=>"252MARATHON",
    "173"=>"24CRISOSTOMO",
    "180"=>"131WOOD",
    "179"=>"42LINARES",
    "178"=>"153SANCRISTOBAL",
    "166"=>"273SANTIAGO"
);

$fuente = 'Yapo';
$hoy = date("Y-m-d H:i:s");
$fecha_dos_hora_menos = strtotime('-1 hour', strtotime($hoy));
$fecha_menos_hora = date("Y-m-d H:i:s", $fecha_dos_hora_menos);
$fecha_una_hora_menos = strtotime('-0 hour', strtotime($hoy));
$fecha_una_hora = date("Y-m-d H:i:s", $fecha_una_hora_menos);
if ($count_leads > 0) {
    for ($pag=1; $pag <= $pages; $pag++) { 
        $data_leads = get_leads($access_token, $pages);
        
        foreach ($data_leads as $leads) {
            $data_cotizante = $leads['buyer'];
            $type_leads = $leads['type'];
            if ($type_leads == 'builder') {
                $fecha_leads = date_format(date_create($leads['created_at']),"Y-m-d H:i:s");
                $proyecto = $leads_ids[strtoupper(trim((String) $leads['object_id']))]; 
                $titulo = $proyecto.'-'.$data_cotizante['email'].'-'.$data_cotizante['phone'];
                $nombre_completo = $data_cotizante['name'];
                $name = $data_cotizante['name'];
                $rutCliente = '';
                $mail = $data_cotizante['email'];
                $telefonoCliente = $data_cotizante['phone'];
        
                if ($fecha_leads > $fecha_menos_hora && $fecha_leads < $fecha_una_hora) {
                    echo 'cumple ' . $fecha_leads . '/' . $fecha_menos_hora;
                    echo '<br>';
                    $body_post_pipedrive = [
                        "title" => $titulo,
                        "value" => $nombre_completo,
                        "currency" =>"CLP",
                        "user_id" => "",
                        "person_id" => "",
                        "dfe9ae38b9a93c369148bd30a2c969ebd8a059f1" => strtoupper(trim($proyecto)),
                        "org_id" => strtoupper(trim($proyecto)),
                        "a053abef1b4aebceb9bb17de7d789fd9a5bf9b9f" => $fuente,
                        "pipeline_id" => $ArrayProjects[strtoupper(trim($proyecto))],
                        "stage_id" => $ArrayStatus[strtoupper(trim($proyecto))],
                        "status" => "open",
                        "expected_close_date" => "",
                        "probability" => "",
                        "lost_reason" => "",
                        "visible_to" => "3",
                        "add_time" => $hoy,
                        "c993dded94c0982d52b9a140717b8a12fbe3ec72-add" => strtoupper(trim($proyecto)),
                        "ff3ab516bad04448ceb525b90cd45ec3cfcdceca" => $mail,
                        "47434ac3577a44c41cbd4650b0185620f0b45310" => $telefonoCliente
                    ];
            
                    // var_dump($body_post_pipedrive);
                    $chAPI = curl_init('https://api.pipedrive.com/v1/deals?api_token='.$authorization_token);
                    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($chAPI, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($chAPI, CURLOPT_POSTFIELDS, http_build_query($body_post_pipedrive));
            
                    $result = curl_exec($chAPI);
                    curl_close($chAPI);
                    echo $result;
                }else{
                    echo 'no cumple'  . $fecha_leads . '/' . $fecha_menos_hora;
                    echo '<br>';
                }
            }
        }
    }
}
?>