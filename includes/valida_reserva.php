<?php

require_once 'db_surmonte.php';

function valida_reserva_cotizacion($id_cotizacion){
    try {
        if (is_null($id_cotizacion)) {
            return false;
        }
        $db = new DB_SM;
        $sql = $db->connect()->prepare("SELECT id_reserva FROM com_tbl_reservas WHERE id_cot = ? LIMIT 1;");
        $sql->execute([$id_cotizacion]);
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        // var_dump($data);
        if (isset($data['id_reserva'])) {
            return true;
        }else{
            return false;
        }
        
    } catch (Exception $e) {
        return false;
    }
}

?>