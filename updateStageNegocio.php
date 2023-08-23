<?php

include 'db_surmonte.php';

date_default_timezone_set('UTC');
$private_app = 'pat-na1-5c5550a6-a597-46b8-a4f4-a777c78da292';

function search_negocio($name_negocio, $private_app){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.hubapi.com/crm/v3/objects/deals/search',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
    
     
    
        "filterGroups": [
    
            {
    
                "filters": [
    
                    {
    
                        "operator": "EQ",
    
                        "propertyName": "dealname",
    
                        "value": "'. $name_negocio .'"
    
                    }
    
                ]
    
            }
    
        ],
    
        "limit": "10",
    
        "properties": [
    
            "hs_object_id"
    
        ],
    
        "sorts": [
    
            "ASCENDING"
    
        ]
    
     
    
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $private_app,
        'Content-Type: application/json'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $get_response_array = json_decode($response, true);
    
    $get_data_response = $get_response_array['results'];
    // $get_id_negocio = $get_data_response['id'];
    $id_negocio = $get_data_response[0]['id'];
    return $id_negocio;
}

function get_escriturados(){
    // iniciar conexion
    $data = [];
    $db = new DB_SM;
    $hoy = date("Y-m-d");
    $fecha_dia_anterior = strtotime('-1 days', strtotime($hoy));
    $fecha_final = date("Y-m-d", $fecha_dia_anterior);
    // // consulta para obtener data escriturados
    $sql = $db->connect()->prepare("SELECT concat(tb.proyecto, ' ', tb.rol) as nombre, ec.created_at as fecha FROM com_tbl_escrituracion ec, `com_tbl_det_escrituracion` ed, tbl_proyectos tb where ec.id = ed.id_escrituracion and ed.id_producto = tb.id and tb.tipo_unidad = 'Departamento' and date_format(ec.created_at, '%Y-%m-%d') = ? ORDER by ec.created_at desc");
    $sql->execute([$fecha_final]);
    // // $datos = $sql->fetch(PDO::FETCH_OBJ);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    ob_clean();
    return json_encode($data);
}

function update_stage_negocio($deal_id, $private_app){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.hubapi.com/crm/v3/objects/deals/' . (String) $deal_id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PATCH',
    CURLOPT_POSTFIELDS =>'{
        "properties": {
            "dealstage": "decisionmakerboughtin"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $private_app,
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}

$deptos_escriturados = json_decode(get_escriturados());
foreach ($deptos_escriturados as $depto) {
    $id_depto_hb = search_negocio($depto->nombre, $private_app);
    $update = update_stage_negocio($id_depto_hb, $private_app);
}

?>