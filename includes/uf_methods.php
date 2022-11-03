<?php

require_once 'db_surmonte.php';

function uf_get($date){
    try {
        $curl = curl_init();
        $ch = curl_init('https://mindicador.cl/api/uf/' . $date);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($res, true);
        $serie = $response['serie'][0];
        $valor = $serie['valor'];
        return $valor;
    } catch (Exception $e){
        return null;
    }
}

function valida_uf(){
    try {
        $hoy = date("d-m-Y");
        $db = new DB_SM;
        $sql = $db->connect()->prepare("SELECT valor FROM uf_flujo_compra WHERE fecha = ?;");
        $sql->execute([$hoy]);
        $data = $sql->fetchAll(PDO::FETCH_NUM);
        if (count($data) != 0) {
            $valor = $data[0][0];
        }else{
            $valor = uf_get($hoy);
            if (is_null($valor)) {
                return null;
            }else{
                $sql = "INSERT INTO uf_flujo_compra (valor, fecha) VALUES (:valor, :fecha);";
                $consulta = $db->connect()->prepare($sql);
                $consulta->bindParam(":valor", $valor, PDO::PARAM_STR);
                $consulta->bindParam(":fecha", $hoy, PDO::PARAM_STR);
                $consulta->execute();
            }
        }
        return $valor;
    } catch (Exception $e) {
        return null;
    }
}

?>