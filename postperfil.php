<?php

    require_once 'includes/db.php';
    // iniciar conexion
    $db = new DB;
    
    $rut = $_POST['rut'];
    $nombre = $_POST['usuario'];
    $correo = $_POST['correo'];
    $pass = $_POST['password'];
    $tel = $_POST['telefono'];
    $passactual = $_POST['passactual'];

    // $ruta = array("nombre" => $nombre, "rut" => $rut, "correo" => $correo, "password" => $pass, "telefono" => $tel);
    // $r = array("rut" => $rut);
    // $nom = array("nombre" => $nombre);

    // $rutQ = json_encode($r);
    // $nomQ = json_encode($nom);

    // echo $rut;
    // echo $nombre;
    $query = $db->connect()->prepare("select * from auth_usuarios 
    where rut = ?;");
    $query->execute([$rut]);
    $query->bindColumn(1, $type, PDO::PARAM_STR, 256);
    $query->bindColumn(2, $lob, PDO::PARAM_LOB);
    $datos = $query->fetch(PDO::FETCH_ASSOC);
    ob_clean();

    if ($pass ===  '' && $passactual === ''){

        $sql = $db->connect()->prepare("update auth_usuarios set nombre= ?, correo = ?, telefono = ? where rut = ? ");
        $sql->execute([$nombre, $correo, $tel ,$rut]);
        $sql->bindColumn(1, $type, PDO::PARAM_STR, 256);
        $sql->bindColumn(2, $lob, PDO::PARAM_LOB);
    
        ob_clean();

        echo true;
    }else{


        $verify = password_verify($passactual, $datos['password']);
        // $verify = true;
        // echo $verify;
        if($verify){
            $password_segura = password_hash($pass, PASSWORD_BCRYPT, ['cost'=>4]);
            $sql = $db->connect()->prepare("update auth_usuarios set nombre= ?, correo = ?, telefono = ?, password = ? where rut = ? ");
            $sql->execute([$nombre, $correo, $tel, $password_segura ,$rut]);
            $sql->bindColumn(1, $type, PDO::PARAM_STR, 256);
            $sql->bindColumn(2, $lob, PDO::PARAM_LOB);
        
            ob_clean();
    
            echo true;
    
        }else{
            
            echo false;
        }
    }



 
 



?>

