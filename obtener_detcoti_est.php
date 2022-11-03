<?php 

    require_once 'includes/db_surmonte.php';

    // iniciar conexion
    $db = new DB_SM;
  
    ///////////////////////////////////////////77
    //recoger datos del formulario
    $idcot = $_POST['idcot'];
    // echo $idcot;

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("SELECT c.nombre, c.piso
    FROM com_tbl_cotizacions a
    inner JOIN com_tbl_detalle_cotizacions b  on a.id = b.id_cotizacion
    INNER JOIN tbl_proyectos c ON b.id_producto = c.id
    WHERE a.id = ? AND c.tipo_unidad = 'Estacionamiento'
    GROUP BY c.nombre,c.piso;");
    $sql->execute([$idcot]);

    $sql->bindColumn(1, $type, PDO::PARAM_STR, 256);
    $sql->bindColumn(2, $lob, PDO::PARAM_LOB);
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    ob_clean();

    
    $datos = array(
        "piso" => $data['piso'],
        "nombre" => $data['nombre']
        );



    
    
    echo json_encode($datos);
    

    // $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>