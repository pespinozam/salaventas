<?php

require_once 'includes/db.php';
require_once 'includes/uf_methods.php';
require_once 'vendor/ti.php';
session_start();

$varsesion = $_SESSION['rut'];

if($varsesion == null || $varsesion = ''){
    header("Location: https://salaventas.surmonte.cl/login.php");
    die();
}
$uf_actual = valida_uf();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <style>
        #a-home{
            color: #fff;
        }
        #a-cotizaciones{
            color: rgb(255,151,53);
        }
    </style>
</head>
<header>
    <?php include 'includes/nav_admin.php';?>
</header>
<body style="background-color: white; font-family: Lato; margin-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col py-3 my-container" id="content">
                <div class="container-fluid mt-5">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">Lo sentimos, productos se encuentran reservados. </h3>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12">
                            <h4 class="text-center">Te invitamos a que cotices nuevamente tus productos, en el siguiente enlace</h4>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 d-flex justify-content-center">
                        <a style="background-color: rgb(255,151,53); color: #fff;" href="proyectos/<?php echo $_GET['proyecto']; ?>.php" type="button" class="btn w-50">
                            Ir a cotizar
                        </a>
                        </div>
                    </div>
                </div>
                <!-- <button id="btn_open_25" class="w3-button w3-teal w3-xlarge" onclick="w3_open(25)">☰</button> -->
                
        
            </div>
        </div>
    </div>
  
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="assets/js/sidebar.js"></script> 
</body>
</html>