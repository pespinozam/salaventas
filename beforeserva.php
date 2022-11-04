<?php 
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    require_once 'includes/db_surmonte.php';

    // iniciar conexion
    $db = new DB_SM;
 
    // $salida = array();
   
    // depto: 59265 | 201 | A1 | 2D + 2B | UF 12796 | NorPoneinteSur | 112.8
    // bod: 59315 | 1 | Bodega | UF 90
    // est: 59289 | 1 | Est. Individual | UF 420
    // total_uf:  13971.3
    // proyecto:  24CRISOSTOMO
    // nombre_completo: patricio espinoza
    // rut: 20.746.511-9
    // correo: espinozapato2001@gmail.com
    // telefono: +56940796547
    // id_cotizacion: 113515

    ///////////////////////////////////////////77
    //recoger datos del formulario
    $id_cotizacion = $_GET['cot']; 
    $proyecto = $_GET['proy']; 
    $total_uf = $_GET['tot']; 
    $nombre_completo = $_GET['nom_cli']; 
    $rut = $_GET['rut_cli']; 
    $correo = $_GET['email']; 
    $telefono = $_GET['fono']; 

    $depto = "";
    $bodega = "0|0|0| UF 0";
    $estacionamiento = "0|0|0| UF 0";
    $errores = array();
    // $sql = $db->connect()->prepare("SELECT a.rut_cliente, a.nombre_cliente, a.telefono1, 
    // a.email, b.proyecto, b.id, b.fecha
    // FROM com_tbl_clientes a
    // inner JOIN com_tbl_cotizacions b  on a.rut_cliente = b.id_cliente
    // WHERE b.id = ?;");
    $sql = $db->connect()->prepare("SELECT c.tipo_unidad, c.id, c.estado
                                    FROM com_tbl_cotizacions a
                                    inner JOIN com_tbl_detalle_cotizacions b  on a.id = b.id_cotizacion
                                    INNER JOIN tbl_proyectos c ON b.id_producto = c.id
                                    WHERE a.id = ?;"
                                    );
    $sql->execute([$id_cotizacion]);
    $tipo_productos = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach ($tipo_productos as $prod) {
        if($prod['tipo_unidad'] == "Departamento"){
            if($prod['estado'] == "Disponible"){
                $sql = $db->connect()->prepare('SELECT CONCAT(c.id, "|", c.nombre, "|", c.tipo, "|", c.programa, "|", c.precio_lista ,"|", c.orientacion, "|", c.superficie_comercial) as prod
                                                FROM tbl_proyectos c
                                                WHERE c.id = ?;'
                                        );
                $sql->execute([$prod['id']]);
                $produ = $sql->fetchAll(PDO::FETCH_NUM);
                
                if(count($produ) == 0){
                    array_push($errores, 'El departamento no se encuentra');
                }else{
                    $depto = $produ[0][0];
                    echo $depto;
                }      
            }else{
                array_push($errores,'El departamento no está disponible');
            }
        }

        if($prod['tipo_unidad'] == "Bodega"){
            if($prod['estado'] == "Disponible"){
                $sql = $db->connect()->prepare('SELECT CONCAT(c.id, "|", c.nombre, "|", c.tipo, "|", c.precio_lista) as bod
                                                FROM tbl_proyectos c
                                                WHERE c.id = ?;'
                                        );
                $sql->execute([$prod['id']]);
                $bod = $sql->fetchAll(PDO::FETCH_NUM);

                if(count($bod) == 0){
                    array_push($errores, 'La bodega no se encuentra');
                }else{
                    $bodega = $bod[0][0];
                    echo $bodega;
                }      
            }else{
                array_push($errores,'La bodega no está disponible');
            }
        }
        if($prod['tipo_unidad'] == "Estacionamiento"){
            if($prod['estado'] == "Disponible"){
                $sql = $db->connect()->prepare('SELECT CONCAT(c.id, "|", c.nombre, "|", c.tipo, "|", c.precio_lista) as est
                                                FROM tbl_proyectos c
                                                WHERE c.id = ?;'
                                        );
                $sql->execute([$prod['id']]);
                $est = $sql->fetchAll(PDO::FETCH_NUM);

                if(count($est) == 0){
                    array_push($errores, 'El estacionamiento no se encuentra');
                }else{
                    $estacionamiento = $est[0][0];
                    echo $estacionamiento;
                }      
            }else{
                array_push($errores,'El estacionamiento no está disponible');
            }
        }
    }

    if(count($errores) == 0){
        
        echo '<form action="reserva.php" method="POST">
        
                    <input type="hidden" name="depto" value="'. $depto .'">
                    <input type="hidden" name="bod" value="'. $bodega .'">
                    <input type="hidden" name="est" value="'. $estacionamiento .'">
                    <input type="hidden" name="total_uf" value="'. $total_uf .'">
                    <input type="hidden" name="proyecto" value="'. $proyecto . '">
                    <input type="hidden" name="nombre_completo" value="' .$nombre_completo .'">
                    <input type="hidden" name="rut" value="' . $rut .'">
                    <input type="hidden" name="correo" value="'. $correo . '">
                    <input type="hidden" name="telefono" value="'. $telefono .'">
                    <input type="hidden" name="id_cotizacion" value="'. $id_cotizacion .'">                 
                    <button id="reservar" class="btn btn-light check_vars">Reservar</button>
            </form>';
        echo '<script>
                function enviar() {
                    document.getElementById("reservar").click();
                }
                enviar();
            </script>';
    }else{
        // $alert =    '<script>
        //                 function alertFN() {
        //                     alert("' ;
        // foreach ($errores as $err) {
        //     $alert = $alert . $err . " ";
        // }
        // $alert = $alert . '")} alertFN();</script>';

        // echo $alert;
        if($enlace_actual == 'http://localhost/salaventas/reserva.php'){
            header("Location: http://localhost/salaventas/prod_no_disponible.php?proyecto=" . $proyecto);
        }else{
            header("Location: https://salaventas.surmonte.cl/prod_no_disponible.php?proyecto=" . $proyecto);
        }
        
                        
    }
?>