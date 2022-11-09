<?php

require_once 'includes/db.php';
require_once 'vendor/ti.php';
session_start();

$varsesion = $_SESSION['rut'];



if($varsesion == null || $varsesion = ''){
    if($llave == true)
    {
        header("Location: https://salaventas.surmonte.cl/login.php");
        die();
    }else{
        header("Location: https://localhost/salaventas/login.php");
    die();
    }

   
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Portal Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">


    <!-- solo chart -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" /> -->
    <style>
        #a-home{
            color: rgb(255,151,53);
        }
    </style>
    <?php startblock('css') ?>

    <?php endblock() ?>
</head>
<header>
    <?php include 'includes/nav_admin.php';?>
</header>
<body style="background-color: white; font-family: Lato; margin-top: 100px;">
<?php 
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$llave = false;
if($enlace_actual == 'http://localhost/salaventas/home.php'){
    $llave = false;
}else{
    $llave = true;
}
?>
    <div class="container">
        <?php startblock('content') ?>
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Mi Panel</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"></li>
                </ol>
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div style="background-color: rgb(255 151 53)" class="card text-white mb-4">
                            <div class="card-body">Cantidad de Cotizaciones abiertas</div>
                            <div class="row">
                                <div class="col">
                                    <div class="card-footer d-flex align-items-center justify-content-between">                                    
                                            <span id="depto"></span>
                                            <br>
                                            <span id="estac"></span>
                                            <br>
                                            <span id="bod"></span>
                                            
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php 
                                        if($llave == true){
                                            echo '<a class="small stretched-link" style="color:white;" href="https://salaventas.surmonte.cl/Vcotizaciones.php">Ver detalle</a>';
                                        }else{
                                            echo '<a class="small stretched-link" style="color:white;" href="http://localhost/salaventas/Vcotizaciones.php">Ver detalle</a>';
                                        }
                                    ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div style="background-color: rgb(255 151 53)" class="card text-white mb-4">
                            <div class="card-body">Cantidad de Reservas en Trámite</div>
                            <div class="row">
                                <div class="col">
                                    <div class="card-footer d-flex align-items-center justify-content-between">                                    
                                            <span id="deptoR"></span>
                                            <br>
                                            <span id="estacR"></span>
                                            <br>
                                            <span id="bodR"></span>
                                            
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <?php 
                                            if($llave == true){
                                                echo '<a class="small text-white stretched-link" href="https://salaventas.surmonte.cl/Vreserva.php">Ver Reservas</a>';
                                            }else{
                                                echo '<a class="small stretched-link" style="color:white;" href="http://localhost/salaventas/Vreserva.php">Ver Reservas</a>';
                                            }
                                        ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
 
                </div>
                <!-- <div class="row">

                    
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Cotizaciones Abiertas por producto
                            </div>
                            <div class="card-body"><canvas id="grafica" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Reservas de Mi Surmonte
                            </div>
                            <div class="card-body"><canvas id="graficaReserva" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                </div> -->
            </div>
        </main>
        <?php endblock() ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="assets/js/sidebar.js"></script>

    <!-- solo chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script> -->
    
    

    
    <?php startblock('js') ?>

    <script type="text/javascript">
        
        function postCotizacion(){
            $.ajax({
            type: "post",
            url: "assets/demo/modelo_grafico.php",
            data: {"rut": "<?php echo $_SESSION['rut']; ?>"},
            success: function (response) {
                const user = JSON.parse(response)
                console.log(user);

                // let goDep = ;

                
                if (typeof $('#depto').text(user.tipo_unidad[0]+': '+user.cantidad[0]) === "undefined") {
                    $('#depto').text('Departamento: 0');
                    // if (typeof user.cantidad[1] === "undefined" || typeof user.cantidad[2] === "undefined"){
                    //     $('#estac').text('Estacionamiento: 0');
                    //     $('#bod').text('Bodega: 0');
                    // }else{
                    //     $('#estac').text('Estacionamiento: '+user.cantidad[1]);
                    //     $('#bod').text('Bodega: '+user.cantidad[2]);
                    // }
                }else{
                    $('#depto').text('Departamento: '+user.cantidad[0]);
                    if (typeof user.cantidad[1] === "undefined" || typeof user.cantidad[2] === "undefined"){
                        $('#estac').text('Estacionamiento: 0');
                        $('#bod').text('Bodega: 0');
                    }else{
                        $('#estac').text('Estacionamiento: '+user.cantidad[1]);
                        $('#bod').text('Bodega: '+user.cantidad[2]);
                    }

                }
                
            }
            });
        }
        function postReserva(){
            $.ajax({
            type: "post",
            url: "assets/demo/grafico_reserva.php",
            data: {"rut": "<?php echo $_SESSION['rut']; ?>"},
            success: function (response) {
                const user = JSON.parse(response)
                console.log(user);
                if (typeof user.cantidad[0] === "undefined") {
                    $('#deptoR').text('Departamento: 0');
                    console.log('sup. deptor'+user.cantidad[1]);
                    if (typeof user.cantidad[1] === "undefined" || typeof user.cantidad[2] === "undefined"){
                        $('#estacR').text('Estacionamiento: 0');
                        $('#bodR').text('Bodega: 0');
                    }else{
                        $('#estacR').text('Estacionamiento: '+user.cantidad[1]);
                        $('#bodR').text('Bodega: '+user.cantidad[2]);
                    }
                    
                }else{
                    $('#deptoR').text('Departamento: '+user.cantidad[0]);
                    console.log('sup. deptor'+user.cantidad[1]);
                    if (typeof user.cantidad[1] === "undefined" || typeof user.cantidad[2] === "undefined"){
                        $('#estacR').text('Estacionamiento: 0');
                        $('#bodR').text('Bodega: 0');
                    }else{
                        $('#estacR').text('Estacionamiento: '+user.cantidad[1]);
                        $('#bodR').text('Bodega: '+user.cantidad[2]);
                    }

                }


                // $('#deptoR').text(user.tipo_unidad[0]+': '+user.cantidad[0]);
                // $('#estacR').text(user.tipo_unidad[1]+': '+user.cantidad[1]);
                // $('#bodR').text(user.tipo_unidad[2]+': '+user.cantidad[2]);
            }
            });
        }

        $(document).ready(function () {
            postCotizacion();
            postReserva();
          
        });

    </script>

    <?php endblock() ?>    
</body>
</html>