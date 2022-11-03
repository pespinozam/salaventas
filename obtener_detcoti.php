
<?php 
    require_once 'includes/uf_methods.php'; 
    $uf_actual = valida_uf();
    require_once 'includes/db_surmonte.php';

    // iniciar conexion
    $db = new DB_SM;
 
    // $salida = array();
   
     

    ///////////////////////////////////////////77
    //recoger datos del formulario
    $idcot = $_POST['idcot'];
    // echo $idcot;

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("SELECT c.proyecto, c.id AS id_product, c.nombre, 
    c.tipo,c.detalle, c.orientacion, c.superficie_comercial, c.tipo_unidad , a.valor_total
    FROM com_tbl_cotizacions a
    inner JOIN com_tbl_detalle_cotizacions b  on a.id = b.id_cotizacion
    INNER JOIN tbl_proyectos c ON b.id_producto = c.id
    WHERE a.id = ? AND c.tipo_unidad = 'Departamento';");
    $sql->execute([$idcot]);

    $sql->bindColumn(1, $type, PDO::PARAM_STR, 256);
    $sql->bindColumn(2, $lob, PDO::PARAM_LOB);
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    ob_clean();


    $valor = number_format($data["valor_total"], 1,',','.');

   
    $vtotal = number_format(($data["valor_total"] * $uf_actual), 1,',','.');;


    $datos = array(
            "proyecto" => $data['proyecto'],
            "id_product" => $data['id_product'],
            "nombre" => $data['nombre'],
            "tipo" => $data['tipo'],
            "detalle" => $data['detalle'],
            "orientacion" => $data['orientacion'],
            "superficie_comercial" => $data['superficie_comercial'],
            "tipo_unidad" => $data['tipo_unidad'],
            "valor_total" => $valor,
            "total_clp" => $vtotal
            );


    echo json_encode($datos);
    // $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    // echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>