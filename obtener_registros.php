<?php 

    require_once 'includes/db_surmonte.php';

    // iniciar conexion
    $db = new DB_SM;
 
    // $salida = array();
   
     

    ///////////////////////////////////////////77
    //recoger datos del formulario
    $rut = $_POST['rut'];

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("SELECT a.email, b.proyecto, b.id AS id_coti, b.estado, date_format(b.fecha, '%d-%m-%Y') as fecha, b.valor_total, a.rut_cliente, a.nombre_cliente, a.telefono1
    FROM com_tbl_clientes a
    inner JOIN com_tbl_cotizacions b  on a.rut_cliente = b.id_cliente
    WHERE b.estado = 'Abierto' AND a.rut_cliente = ? 
    ORDER BY b.fecha DESC;");
    $sql->execute([$rut]);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data, JSON_UNESCAPED_UNICODE);


?>