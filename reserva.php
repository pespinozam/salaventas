<?php 


$depto = $_POST["depto"];
$est = $_POST["est"];
$bod = $_POST["bod"];
$total_uf = $_POST["total_uf"];
$proyecto = $_POST["proyecto"];

$nombre = $_POST["nombre_completo"];
$correo = $_POST["correo"];
$rut = $_POST["rut"];
$telefono = $_POST["telefono"];
$id_cotizacion = $_POST["id_cotizacion"];

$departamento_values = explode("|",$depto);
$bodega_values = explode("|",$bod);
$estacionamiento_values = explode("|",$est);

?>
<!DOCTYPE html>
<html>
<head>
<title>Reserva - Pago</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="shB284-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
// <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .check_vars{
    background-color: #f15a24;
    color: white; 
}

.card-header{
    background-color: #f15a24;
}

.card-title {
    color: white;
}
</style>

</head>
<body style="background-color: black; font-family: 'Lato', sans-serif;">
<?php

?>
<br>
<div style="background-color: white;" class="container">
<div class="row">
    <div class="col-12 col-md-12 d-flex justify-content-center p-4" style="background-color: black; color:white;">
      <img width="350" src="assets/Logo_surmonte_2.png"></img>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12 d-flex justify-content-center" >
      <h2 class="mt-4">Hola, <b><?php echo $nombre; ?></b></h2>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12 d-flex justify-content-center">
        <h2 class="mt-2 p-2">¡Estás a un paso de tu <strong> Surmonte!</strong></h2>
    </div>
</div>
<hr>
<div class="row">
    <div  class="col-12 col-md-6 mt-4">
      <div class="card">
        <div class="card-header" style="background-color: black; color:white;">
          <div  class="row">
              <h4 class="d-flex justify-content-center mb-2" >Checkout </h4>
            </div>
        </div>
        <div class="card-body">
          <br>   
                  <strong><h4 class="d-flex justify-content-center mb-2">Proyecto: <span id="proyect"><?php echo $proyecto ?></span></strong></h4>
                  <hr>
                  <h4>Departamento: <?php echo $departamento_values[1]; ?></h4>
                  <h4>Tipología: <?php echo $departamento_values[2]; ?></h4>
                  <h4>Programa: <?php echo $departamento_values[3]; ?></h4>
                  <h4>Orientación: <?php echo $departamento_values[5]; ?></h4>
                  <h4>Superficie total: <?php echo $departamento_values[6]." <small>m2</small> (*)"; ?></h4>
                  <h4>N° de Estacionamiento:  <?php echo $bodega_values[1]?></h4>
                  <h4>N° de Bodega:  <?php echo $estacionamiento_values[1]?></h4>
                  <hr>
                  <h2 class="text" style="color: rgb(255 151 53)"><?php echo "Precio total:  UF".number_format($total_uf,1,",",".")." <small>(**)</small>"?></h2>
                  <h2 class="text" style="color: rgb(255 151 53)"><?php echo "Pago reserva: $150.000 <small>(***)</small>"; ?></h2>
                  <hr>
                  <?php 
                    echo '<form method="post" action="https://salaventas.surmonte.cl/transaction.php?action=create">';
                    
                  ?>
                  <!-- <form method="post" action="https://salaventas.surmonte.cl/transaction.php?action=create"> -->
                  <div class="d-grid">
                    <input type="hidden" name="cotizacion" value="<?php echo $id_cotizacion; ?>" >
                    <input type="hidden" name="proyecto" value="<?php echo $proyecto; ?>" >
                    <input type="hidden" name="rut" value="<?php echo $rut; ?>">
                    <?php if($departamento_values[0] != '0'){ echo '
                          <input type="hidden" name="id_prod[]" value="'.$departamento_values[0].'"> '; } ?>
                    <?php if($bodega_values[0] != '0'){ echo '
                          <input type="hidden" name="id_prod[]" value="'. $bodega_values[0].'"> '; } ?>
                    <?php if($estacionamiento_values[0] != '0'){ echo '
                          <input type="hidden" name="id_prod[]" value="'.$estacionamiento_values[0] .'"> '; } ?>
                    <?php if($departamento_values[4] != ' UF 0'){ echo '
                          <input type="hidden" name="precios_prod[]" value="'.$departamento_values[4] .'"> '; } ?>
                    <?php if($bodega_values[3] != ' UF 0'){ echo '
                          <input type="hidden" name="precios_prod[]" value="'.$bodega_values[3] .'"> '; } ?>
                    <?php if($estacionamiento_values[3] != ' UF 0'){ echo '
                          <input type="hidden" name="precios_prod[]" value="'.$estacionamiento_values[3] .'"> '; } ?>
                    <input type="submit" class="btn btn-dark btn-block text-lg" value="Ir a pagar" />
                    <input type="hidden" name="telefono" value="<?php echo $telefono; ?>">
                    <input type="hidden" name="correo" value="<?php echo $correo; ?>">
                    <input type="hidden" name="nombre_completo" value="<?php echo $nombre; ?>">
                  </div>
                  </form>
        </div>
      </div>
    </div>
    <div  class="col-12 col-md-6 mt-4">
      <div class="card">
        <div class="card-header" style="background-color: black; color:white;">
          <div  class="row">
              <h4 class="d-flex justify-content-center mb-2" >Tu Surmonte</h4>
            </div>
        </div>
        <div class="card-body">
              <div id="contenido"></div>
        </div>
      </div>
    </div>
</div>
<hr>
<div class="row">
  <div class="col-12 col-md-12">
    <ul>
      <li> <small> (*) Superficie total: Suma de la superficie edificada de las unidades que conforman un edificio, calculada hasta el eje de los muros o líneas divisorias entre ellas y la superficie común. (Art. 1.1.2. OGUC). </small></li>
      <li> <small> (**) Precio total: Incluye el valor de estacionamiento y bodega seleccionadas, detalladas en esta cotización.</small></li>
      <li> <small> (***) Pago reserva: Es el valor en CLP que debe pagar para poder reservar los productos listados.</small></li>
      <li> <small> OGUC: Ordenanza General de Urbanismo y Construcciones.</small></li>
    </ul>      
  </div>
</div>
     
<div class="row">
    <div class="col-12 col-md-12 mb-5 text-justify">
      <small> Nos pondremos en contacto contigo a través de tu correo electrónico  <a href='mailto:<?php echo $correo; ?>'><?php echo $correo; ?></a> o al teléfono <a href='tel:<?php echo $telefono?>'><?php echo $telefono; ?></a> para gestionar y acompañarte en el proceso de Promesa de tu <b>Surmonte</b>.  Si tienes dudas, contáctanos  al teléfono  <b>223078877</b> o al correo <b> bsaavedra@surmonte.cl.</small>
    </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://kit.fontawesome.com/f5939545a8.js" crossorigin="anonymous"></script>
</body>
</html>
<script>
$(document).ready(function(){

  var proyecto = $("#proyect").text(); 
  $.ajax({
                url: 'carrousel/carousel_proyectos.php',
                type: 'POST',
                data: {
                  proyecto: proyecto
                  },
                success: function (response) {
                   $("#contenido").html(response);

             }
          });
});
     
</script>