<?php 

    require_once 'includes/db.php';

    // iniciar conexion
    $db = new DB;

    //recoger datos del formulario
    $rut = $_POST['rut'];

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("select * from auth_usuarios 
    where rut = ?;");
    $sql->execute([$rut]);
    // var_dump($sql->execute([$rut]);)
    // $datos = $sql->fetch(PDO::FETCH_OBJ);

    // le paso los datos pdo para que me retorne true,
    // pero no me trae un array de datos 
    $sql->bindColumn(1, $type, PDO::PARAM_STR, 256);
    $sql->bindColumn(2, $lob, PDO::PARAM_LOB);
    $datos_perfil = $sql->fetch(PDO::FETCH_ASSOC);
    ob_clean();

    echo json_encode($datos_perfil);
?>