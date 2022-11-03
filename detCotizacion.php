<?php

require_once 'includes/db.php';
require_once 'vendor/ti.php';
session_start();

$varsesion = $_SESSION['rut'];

if($varsesion == null || $varsesion = ''){
    header("Location: http://localhost/flujocompra/login.php");
    die();
}

?>

<?php require_once 'includes/uf_methods.php'; ?>
<?php  

$uf_actual = valida_uf();

$ct = $_GET['cot'];
$email = $_GET['email'];
$fono = $_GET['fono'];
$rut_cli = $_GET['rut'];
$nom_cli = $_GET['nom'];

// echo $uf_actual;

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
</head>
<header>
    <?php include 'includes/nav_admin.php';?>
</header>
<body style="background-color: white; font-family: Lato; margin-top: 100px;">
    <div class="container">
        <div class="container-fluid">

   <div class="row mx-5 mt-5">
       <h3>Detalle Cotización</h3>
       <hr class="">
       <h4>Folio: <?php echo  $ct; ?></h4>
      <div class="col-12 col-md-6 justify-content-center justify-content-md-start">
         
      </div>
      <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end">
         <a href="http://localhost/flujocompra/index.php" type="button" id="btnMinimizar" style = "background-color: rgb(255 151 53); color: white;" data-card-widget="collapse" class="btn p-1 m-1" style="">
         Nueva cotización</a>
      </div>
   </div>
   <div class="row mt-5 mx-5">
      <div class="col-12">
        <div class="row">
                <div  class="col-12 col-md-12 d-flex justify-content-center p-4">
                    <div class="row">
                        <div class="col-12 col-md-12">

                            <div class="card">
                                <div class="card-header" style="background-color: black; color:white;">
                                    <div  class="row">
                                        <h4 class="d-flex justify-content-center mb-2" ></h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <br> 
                                    <strong><h4 class="d-flex justify-content-center mb-2"><span id="Project"></span> </strong></h4>
                                    <hr>
                                    <h4>Departamento: <span id="Depto"></span> </h4>
                                    <h4>Tipología: <span id="Tipologia"></span> </h4>
                                    <h4>Programa: <span id="Programa"></span> </h4>
                                    <h4>Orientación: <span id="Orientación"></span> </h4>
                                    <h4>Superficie total: <span id="sTotal"></span>  <small>m2</small> (*)</h4>
                                    <!-- <h4>N° de Estacionamiento: <span id="Estacionamiento"></span> </h4>
                                    <h4>N° de Bodega: <span id="Bodega"></span> </h4> -->
                                    <!-- <hr> -->
                                </div>
                                <div class="card-body" style="display: block;" id="bodyEstacionamiento">
                                    <br> 
                                    <strong><h4 class="d-flex justify-content-center mb-2">Estacionamiento
                                    </strong></h4>
                                    <hr>
    
                                    <h4>Piso:  <span id="Estacionamiento"></span> </h4>
                                    <h4>Número:  <span id="nombreEst"></span> </h4>
                                    
                                    <hr>
                                </div>
                                <div class="card-body" style="display: block;" id="bodyBodega">
                                    <br> 
                                    <strong><h4 class="d-flex justify-content-center mb-2">Bodega
                                    </strong></h4>
                                    <hr>
    
                                    <h4>Cantidad de Bodega:  <span id="countBodega" ></span> </h4>
                                    
    
                                    <hr>
                                    <h2 class="text" style='color: rgb(255 151 53);'> Precio Total: UF <span id="preciototal" value="0"></span> </h2>
                                    <h2 class="text"> <span ></span></h2>
                                    
                                    <hr>
                                </div>
                                
                                <div style='text-align: center'>
                                    <div class="d-grid gap-2 col-6 mx-auto ">
                                        
                                        <form method="POST" action="pdfdetcoti.php" target="_blank">
                                        <!-- $uf_actual = valida_uf();-->
                                            <input type="hidden" id="uf_dia" name="uf_dia" value="<?php echo $uf_actual;?>">
                                            <input type="hidden" id="coti" name="coti" value="<?php echo $ct;?>">
                                            <input type="hidden" id="email" name="email" value="<?php echo $email;?>">
                                            <input type="hidden" id="fono" name="fono" value="<?php echo $fono;?>">
                                            <input type="hidden" id="rut_cli" name="rut_cli" value="<?php echo $rut_cli;?>">
                                            <input type="hidden" id="nom_cli" name="nom_cli" value="<?php echo $nom_cli;?>">
    
                                            <input type="hidden" id="clptotal" name="clptotal" value="">
                                            <input type="hidden" id="proy" name="proy" value="">
                                            <input type="hidden" id="deptop" name="deptop" value="">
                                            <input type="hidden" id="tipolog" name="tipolog" value="">
                                            <input type="hidden" id="program" name="program" value="">
                                            <input type="hidden" id="orienta" name="orienta" value="">
                                            <input type="hidden" id="suptol" name="suptol" value="">
                                            <input type="hidden" id="ubiEst" name="ubiEst" value="">
                                            <input type="hidden" id="nombreEst" name="nombreEst" value="">
                                            <input type="hidden" id="cantBod" name="cantBod" value="">
                                            <input type="hidden" id="priceTal" name="priceTal" value="">
    
                                            <button type="submit" style='background-color: rgb(255 151 53); color: white;' class="btn">Descargar cotización</button>
                                            <a type='button' href="https://salaventas.surmonte.cl/Vcotizaciones.php" style='padding: 3px; margin: 3px; background-color: rgb(255 151 53); color: white;' class='btn'>Volver</a>
                                            <!-- <a href="../email.php" role="button" class="btn btn-light check_vars">Enviar mail </a> -->
                                        </form>
                                        </div>
                                </div>
                                
                                
                                
                            </div>
                        </div>

                    </div>


                </div>
        </div>
 

      </div>
   </div>

</div>




<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">

<!-- medias para tabla -->

<style>
   /* TD */
   @media (max-width:768px){
            #btnLI{
                display:none;
            }
        }



        /* LI */
        @media (min-width:768px){
            #btnTD{
                display: block !important;
                
            }   

        }
</style>

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="assets/js/sidebar.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>



<script type="text/javascript">




function getDataUser(){
        $.ajax({
        type: "post",
        url: "obtener_detcoti.php",
        data: {"idcot": "<?php echo  $ct; ?>"},
        success: function (response) {
            const user = JSON.parse(response)
            // console.log(user);

            // spans
            $('#Project').text(user.proyecto);
            $('#Depto').text(user.nombre);
            $('#Tipologia').text(user.tipo);
            $('#Programa').text(user.detalle);
            $('#Orientación').text(user.orientacion);
            $('#sTotal').text(user.superficie_comercial);
            $('#preciototal').text(user.valor_total);
            

            
            // inputs detalle
            $('#Project').text(user.proyecto);
            $('#Depto').text(user.nombre);
            $('#Tipologia').text(user.tipo);
            $('#Programa').text(user.detalle);
            $('#Orientación').text(user.orientacion);
            $('#sTotal').text(user.superficie_comercial);
            $('#preciototal').text(user.valor_total);
            
            
            
            // inputs descargar comprobante
            $('#proy').val(user.proyecto);
            $('#deptop').val(user.nombre);
            $('#tipolog').val(user.tipo);
            $('#program').val(user.detalle);
            $('#orienta').val(user.orientacion);
            $('#suptol').val(user.superficie_comercial);
            
            $('#priceTal').val(user.valor_total); // total prop uf
            $('#clptotal').val(user.total_clp); // total_prop clp

        }
        });
    }
    function getDataEsta(){
        $.ajax({
        type: "post",
        url: "obtener_detcoti_est.php",
        data: {"idcot": "<?php echo  $ct; ?>"},
        success: function (response) {
            const user = JSON.parse(response)
            console.log(user);

            // $('#Estacionamiento').text(user.piso);
            var hest= user.nombre;

            if (hest != null){
                // alert("hay")
                $('#Estacionamiento').text(user.piso);
                $('#nombreEst').text(user.nombre);
                // inputs descargar comprobante
                $('#ubiEst').val(user.piso);
                $('#nombreEst').val(user.nombre);
            }else{
                $('#bodyEstacionamiento').css("display", "none");
            }
        }
        });
    }
    function getDataBod(){
        $.ajax({
        type: "post",
        url: "obtener_detcoti_bod.php",
        data: {"idcot": "<?php echo  $ct; ?>"},
        success: function (response) {
            const user = JSON.parse(response)
            console.log(user);
            // console.log('cant bod'+user.cant_bod);

            var cantBod = user.cant_bod;
            console.log('variable cantbod: '+user.cant_bod)
            if (cantBod != null){
                // alert("hay")
                $('#countBodega').text(user.cant_bod);

                // inputs descargar comprobante
                $('#cantBod').val(user.cant_bod);

            }else{
                $('#bodyBodega').css("display", "none");
            }


        }
        });
    }


var mediaqueryList = window.matchMedia("(orientation: portrait)");


$(document).ready(function () {
    getDataUser();
    getDataEsta();
    getDataBod();
   
});


</script>

</body>
</html>