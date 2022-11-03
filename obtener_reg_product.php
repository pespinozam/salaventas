<?php 

    require_once 'includes/db_surmonte.php';

    // iniciar conexion
    $db = new DB_SM;
 
    // $salida = array();
   
     

    ///////////////////////////////////////////77
    //recoger datos del formulario
    $rut = $_POST['rut'];

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("SELECT b.id_producto, a.categoria, a.tipo_unidad,  
    a.rol, a.proyecto,b.estado, a.detalle 
    FROM tbl_proyectos a
    INNER JOIN com_tbl_det_reservas b ON a.id = b.id_producto
    INNER JOIN com_tbl_reservas c ON b.id_reserva=c.id_reserva
    WHERE c.rut_cli = ?;");
    $sql->execute([$rut]);
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>