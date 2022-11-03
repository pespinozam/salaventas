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
    $sql = $db->connect()->prepare("SELECT a.nombre, a.tipo, a.proyecto, a.piso
    FROM tbl_proyectos a
    INNER JOIN com_tbl_det_reservas b ON a.id = b.id_producto
    INNER JOIN com_tbl_reservas c ON b.id_reserva=c.id_reserva
    WHERE b.id_producto = :id_cot AND rut_cli= :rut ;");
    $sql->bindParam(":id_cot", $idcot, PDO::PARAM_INT);
    $sql->bindParam(":rut", $rut, PDO::PARAM_STR);
    $sql->execute();

    
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    ob_clean();


    // $valor = number_format($data["valor_total"], 2,',','.');

   
    


    $datos = array(
            // "id_product" => $data['id_producto'],
            "proyecto" => $data['proyecto'],
            "nombre" => $data['nombre'],
            "tipo" => $data['tipo'],
            "piso" => $data['piso']
            // "rol" => $data['rol'],
            // "superficie_comercial" => $data['superficie_comercial'],
            // "cantidad_pisos" => $data['cantidad_pisos'],
            // "orientacion" => $data['orientacion'],
            // "programa" => $data['programa']
      
            );


    echo json_encode($datos);
    // $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>