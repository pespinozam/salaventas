<?php 

    require_once 'includes/db_surmonte.php';

    // iniciar conexion
    $db = new DB_SM;
 
    // $salida = array();
    ///////////////////////////////////////////77
    //recoger datos del formulario
    $idcot = $_POST['idcot'];
    $rut = $_POST['rut'];
    // echo $idcot;

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("SELECT a.nombre, a.rol, a.proyecto, a.piso
    FROM tbl_proyectos a
    INNER JOIN com_tbl_det_reservas b ON a.id = b.id_producto
    INNER JOIN com_tbl_reservas c ON b.id_reserva=c.id_reserva
    WHERE b.id_producto = :id_cot AND rut_cli= :rut ;");
    $sql->bindParam(":id_cot", $idcot, PDO::PARAM_INT);
    $sql->bindParam(":rut", $rut, PDO::PARAM_STR);
    $sql->execute();

    
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    ob_clean();

    $datos = array(
  
            "proyecto" => $data['proyecto'],
            "nombre" => $data['nombre'],
            "tipo" => $data['rol'],
            "piso" => $data['piso']
 
            );


    echo json_encode($datos);
 

?>