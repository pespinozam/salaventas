<?php include 'home.php' ?>

<?php  
$ct = $_GET['prod']; 
$rut = $_GET['rut_cli'];
// echo $rut;
$llave = false;
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if($enlace_actual == 'http://localhost/salaventas/detProdBod.php'){
    $llave = false;
}else{
    // header("Location: https://salaventas.surmonte.cl/index.php");
    $llave = true;
}
?>

<?php startblock('content') ?>


<div class="container-fluid">

   <div class="row mx-5 mt-5">
      <div class="col-12 col-md-6 justify-content-center justify-content-md-start">
         <h3>Detalle Bodega</h3>
         <hr>
         <h5>ID producto: <?php echo  $ct; ?></h5>
         
      </div>

   </div>
   <div class="row mt-5 mx-5">
      <div class="col-12">
        <div class="row">
                <div  class="col-12 col-md-12 d-flex justify-content-center p-4">
                    <div class="row">
                        <div class="card">
                            <div class="card-header" style="background-color: black; color:white;">
                                <div  class="row">
                                    <h4 class="d-flex justify-content-center mb-2" ></h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <br> 
                                <strong><h4 class="d-flex justify-content-center mb-2">Proyecto: <span id="Project"></span> </strong></h4>
                                <hr>
                                <h4>N° Bodega:    <span id="uBod"></span> </h4>
                                <h4>Tipología:   <span id="Tipologia"></span> </h4>
                                <h4>Piso N°:     <span id="nPiso"></span></h4>
                                <!-- <h4>N° de Estacionamiento: <span id="Estacionamiento"></span> </h4>
                                <h4>N° de Bodega: <span id="Bodega"></span> </h4> -->
                                <!-- <hr> -->
                            </div>
                            <div class="card-body">
                                <br> 

                                <div style='text-align: center'>
                                    <div class="d-grid gap-2 col-6 mx-auto ">
                                        <button type='button' style='padding: 6px; background-color: rgb(255 151 53); color: white' class='form btn mb-4'>Descargar</button>
                                        <?php 
                                            if($llave == true){
                                                echo '<a type="button" href="https://salaventas.surmonte.cl/misproductos.php" style="padding: 6px; background-color: rgb(255 151 53); color: white;" class="form btn mb-4">Volver</a>';
                                            }else{
                                                echo '<a href="http://localhost/salaventas/misproductos.php" type="button" id="btnMinimizar" style = "background-color: rgb(255 151 53); color: white;" data-card-widget="collapse" class="btn p-1 m-1" style="">Volver</a>';
                                            }
                                        ?>
                                        
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



<?php endblock(); ?>

<?php startblock('css') ?>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">


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

<?php endblock() ?>


<?php startblock('js') ?>

<script type="text/javascript">

function getDataProd(){
        $.ajax({
        type: "post",
        url: "obtener_detprodBod.php",
        data: {"idcot": "<?php echo  $ct; ?>", "rut":"<?php echo  $rut; ?>"},
        success: function (response) {
            const user = JSON.parse(response)
            console.log(user);

            $('#Project').text(user.proyecto);
            $('#uBod').text(user.nombre);
            $('#Tipologia').text(user.tipo);
            $('#nPiso').text(user.piso);
            
        }
        });
    }



var mediaqueryList = window.matchMedia("(orientation: portrait)");


$(document).ready(function () {
    getDataProd();
 ;
   
});


</script>

<?php endblock() ?>