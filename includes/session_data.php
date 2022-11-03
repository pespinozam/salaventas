<?php

require_once 'db_surmonte.php';

function data_user_session($rut){
    try {
        $db = new DB_SM;
        $sql = $db->connect()->prepare("SELECT nombre_cliente, rut_cliente, email, telefono1 FROM com_tbl_clientes WHERE rut_cliente = ? LIMIT 1;");
        $sql->execute([$rut]);
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($data) == 0) {
            $data = [];
        }
        return $data;
    } catch (Exception $e) {
        $data = [];
        return $data;
    }
}

?>