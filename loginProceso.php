<?php
    
    //iniciar la sesión y la conexión a bd
    require_once 'includes/db.php';

    // iniciar conexion
    $db = new DB;

    //recoger datos del formulario
    $rut = trim($_POST['usuario']);
    $rut = str_replace(".", "", $rut);
    $password = $_POST['contraseña'];

    // consulta para comprobar las credenciales del usuario
    $sql = $db->connect()->prepare("select * from auth_usuarios 
    where rut = :rut;");
    $sql->bindParam(":rut", $rut, PDO::PARAM_STR);
    $sql->execute();
    $datos = $sql->fetch(PDO::FETCH_ASSOC);

    // le paso los datos pdo para que me retorne true,
    // pero no me trae un array de datos 
  
    $verify = password_verify($password, $datos['password']);

    if($verify){

        //le pasamos los datos a la sesion
        session_start();
        $_SESSION['nombre'] = $datos['nombre'];
        $_SESSION['rut'] = $datos['rut'];

        
        // $_SESSION['pass'] = $datos['password'];
        // $_SESSION['correo'] = $datos['correo'];
        
        $respuesta = array("nombre" => $_SESSION['nombre'],
                           "rut" => $_SESSION['rut'],
                           "estado" => "exito");

        echo json_encode($respuesta);

        
    }else{
        
        //session_start();
        $respuesta = array(
        "estado" => "error");

        echo json_encode($respuesta);
       // $_SESSION['error_login'] = "Login incorrecto";
        
    }

    
?>