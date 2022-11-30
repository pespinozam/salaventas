

<?php include 'home.php' ?>
<?php require_once 'includes/uf_methods.php'; ?>
<?php  
$uf_actual = valida_uf();
$ct = $_GET['cot']; 

?>

<?php startblock('content') ?>


<div class="container-fluid">
    <?php
    
     ?>

    <div class="row mx-5 mt-5">
        <h3>Detalle Reserva</h3>
        <hr class="">
        <h4>Folio: <?php echo  $ct; ?></h4>
      <div class="col-12 col-md-6 justify-content-center justify-content-md-start">
          
         
      </div>
      <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end">
         <a type="button" id="btnCoti" href="https://salaventas.surmonte.cl/" style="background-color: rgb(255 151 53); color: white;" data-card-widget="collapse" class="btn p-1 m-1" style="">
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
    
                                    <h4>Piso: <span id="Estacionamiento"></span> </h4>
                                    <h4>Número: <span id="nombreEst"></span> </h4>
                                    
                                    <hr>
                                </div>
                                <div class="card-body" style="display: block;" id="bodyBodega">
                                    <br> 
                                    <strong><h4 class="d-flex justify-content-center mb-2">Bodega
                                    </strong></h4>
                                    <hr>
    
                                    <h4>Cantidad de Bodega: <span id="countBodega" ></span> </h4>
    
                                    <hr>
                                    <h2 class="text" style="color: rgb(255 151 53)"> Precio Total: UF <span id="preciototal" value="0"></span> </h2>
                                    <h2 class="text-danger"> <span ></span></h2>
                                    
                                    <hr>
                                </div>
    
                                <div style='text-align: center'>
                                    <div class="d-grid gap-2 col-6 mx-auto ">
                                        
                                        <form method="POST" action="pdfreservas.php" target="_blank">
                                        <!-- $uf_actual = valida_uf();-->
                                            <input type="hidden" id="uf_dia" name="uf_dia" value="<?php echo $uf_actual;?>">
                                            <input type="hidden" id="coti" name="coti" value="<?php echo $ct;?>">
    
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
    
                                            <button type="submit" style='background-color: rgb(255 151 53); color: white;' class='form btn mb-4'>Descargar reserva</button>
                                            <?php 
                                                echo '<a type="button" href="https://salaventas.surmonte.cl/Vreserva.php" style="padding: 3px; margin: 3px; background-color: rgb(255 151 53); color: white;" class="btn">Volver</a>';
                                                
                                            ?>
                                            
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


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>


<script type="text/javascript">

function getDataUser(){
        $.ajax({
        type: "post",
        url: "obtener_detcoti.php",
        data: {"idcot": "<?php echo  $ct; ?>"},
        success: function (response) {
            const user = JSON.parse(response)
            console.log(user);

            $('#Project').text(user.proyecto);
            $('#Depto').text(user.nombre);
            $('#Tipologia').text(user.tipo);
            $('#Programa').text(user.detalle);
            $('#Orientación').text(user.orientacion);
            $('#sTotal').text(user.superficie_comercial);
            $('#preciototal').text(user.valor_total);

            $('#proy').val(user.proyecto);
            $('#deptop').val(user.nombre);
            $('#tipolog').val(user.tipo);
            $('#program').val(user.detalle);
            $('#orienta').val(user.orientacion);
            $('#suptol').val(user.superficie_comercial);
            
            $('#priceTal').val(user.valor_total); // total prop uf
            $('#clptotal').val(user.total_clp);

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
            // console.log(user.nombre);
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

<?php endblock() ?>