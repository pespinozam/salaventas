<?php 

    require_once '../../includes/db_surmonte.php';

    // iniciar conexion
    $db = new DB_SM;
  
    ///////////////////////////////////////////77
    //recoger datos del formulario
    // $idcot = $_POST['idcot'];
    // echo $idcot;

    $rut = $_POST['rut'];

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("SELECT c.tipo_unidad,count(c.tipo_unidad) AS cantidad 
    FROM com_tbl_cotizacions a
    inner JOIN com_tbl_detalle_cotizacions b  on a.id = b.id_cotizacion
    INNER JOIN tbl_proyectos c ON b.id_producto = c.id
    WHERE a.id_cliente = :rut AND a.estado = 'Abierto'
    GROUP BY c.tipo_unidad ");
    $sql->bindParam(":rut", $rut, PDO::PARAM_STR);
    $sql->execute();

    
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    ob_clean();


    // $valor = number_format($data["valor_total"], 2,',','.');

    // $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $list1 = array();
    $list2 = array();

    foreach ($data as $row) {
       array_push($list1,$row['tipo_unidad']);
       array_push($list2,$row['cantidad']);
    //    echo $row['cantidad'];
   
    }
    
    

    $datos = array(
            "tipo_unidad" => $list1,
            "cantidad" => $list2
      
            );


    // echo json_encode($datos);
    // $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($datos);

?>