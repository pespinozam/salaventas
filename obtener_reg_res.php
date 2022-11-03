<?php 

    require_once 'includes/db_surmonte.php';

    // iniciar conexion
    $db = new DB_SM;
 
    // $salida = array();
   
     

    ///////////////////////////////////////////77
    //recoger datos del formulario
    $rut = $_POST['rut'];

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("SELECT DISTINCT (b.id_cot), a.id_reserva,b.rut_cli, a.proyecto, a.estado, b.id_cot, b.fec_res
    FROM com_tbl_det_reservas a
    INNER JOIN com_tbl_reservas b ON a.id_reserva=b.id_reserva
    WHERE b.rut_cli = ?");
    $sql->execute([$rut]);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>