<?php
require_once '../includes/session_data.php';
require_once '../includes/uf_methods.php';
session_start();

$link = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$escaped_link = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
// echo 'link: '.$escaped_link.'.';

if (isset($_SESSION['rut'])) {
    $session_data = data_user_session($_SESSION['rut']);
}
$uf_actual = valida_uf();
$hoy = date('Y-m-d');
// isset($_SESSION['rut']) ? $_SESSION['rut'] : 'Invitado';


if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    

$id = "42LINARES";
$login = 'apisurmonte';
$password = 'API2021_smnt';
$url = 'https://api.surmonte.cl/v1/productos?proyecto='.$id;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
$result = curl_exec($ch);
curl_close($ch);

$decoded_json = json_decode($result, true);

$tipologias = array();
$departamentosA1 = array();
$departamentosA2 = array();
$departamentosB = array();
$departamentosA3 = array();
$departamentosA4 = array();
$departamentosD = array();
$departamentosC3 = array();
$bodegas = array();
$estacionamientos = array();
$plantas = array();

foreach ($decoded_json as $rkey => $resource){

   $tipologias[] = array("tipo" => $resource["productos_tipo"]);

}

 foreach ($decoded_json as $rkey => $resource){

    if($resource["productos_tipo_unidad"] == "Departamento" )
    {
        $plantas[] =  $resource["productos_tipo"];
        
    }
}

foreach($decoded_json as $rkey => $resource) {
    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A1"){
      $departamentos[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | ".$resource["productos_cantidad_dormitorios"]."D + ".$resource["productos_cantidad_banios"]."B | UF ".$resource["productos_precio_lista"]." | ".$resource["productos_orientacion"];
    }
}

foreach ($decoded_json as $rkey => $resource){
    if($resource["productos_tipo_unidad"] == "Bodega" )
    {
        $bodegas[] = $resource["productos_id"]. " | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | UF ".$resource["productos_precio_lista"];
    }
 
 }

 foreach ($decoded_json as $rkey => $resource){
    if($resource["productos_tipo_unidad"] == "Estacionamiento" )
    {
        $estacionamientos[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | UF ".$resource["productos_precio_lista"];
    }
 
 }
$link_logo = "../assets/linares-logo.png";
?>
<!DOCTYPE html>
<html>
<head>
<title>42LINARES</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/sidebar.css">
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

.select2 {
    width:100%!important;
}

#myBtn {
  display: none; /* Hidden by default */
  position: fixed; /* Fixed/sticky position */
  bottom: 20px; /* Place the button at the bottom of the page */
  right: 30px; /* Place the button 30px from the right */
  z-index: 99; /* Make sure it does not overlap */
  border: none; /* Remove borders */
  outline: none; /* Remove outline */
  background-color: black; /* Set a background color */
  color: white; /* Text color */
  cursor: pointer; /* Add a mouse pointer on hover */
  padding: 15px; /* Some padding */
  border-radius: 10px; /* Rounded corners */
  font-size: 18px; /* Increase font size */
}

#myBtn:hover {
  background-color: #555; /* Add a dark-grey background on hover */
}


</style>
</head>
<header>
<?php include '../includes/nav_index.php';?>
</header>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="50" style="background-color: white; font-family: Lato; margin-top: 100px;">


<span style="display: none;" id="proyecto">42LINARES</span>

<div class="modal" id="loader" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Estamos generando tu <b>cotización</b>...</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <center><img width="300" src="../assets/surmonte-logo-1.png"></img></center>
                </div>
                <div class="col-md-12">
                    <center><img width="150" src="../assets/loading.gif"></img></center>
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <hr>
          </div>
        </div>
      </div>
</div>
<!-- BUTTON ON THE TOP -->
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa-solid fa-circle-arrow-up"></i></button>

<div class="container">
<div class="row bg-secondary" id="logo-cel" style="display: none; margin-bottom: 20px;">
    <div class="col-12 d-flex justify-content-center">
    <img class="logo-name" src="<?php echo $link_logo; ?>" alt="Surmonte Logo" style="width:200px;"></img>
    </div>
</div>
<div class="row">
<div class="col-12 col-md-12 mb-5">
    <h1 class="d-flex justify-content-center"><b>¡Bienvenido a la nueva experiencia!</b></h1>
</div>
<div class="row">
    <div class="col-12">
     <h3 class="d-flex justify-content-center">Cotiza nuestros productos</strong></h3>
    </div>
</div>
<div class="row">
        <div class="col-12 col-md-12 d-flex justify-content-end mb-5">
            <table class="table" style="text-align: right; width: 30%">
                <thead>
                <tr>
                    <th style="width:40%;">Fecha</th>
                    <th style="width:20%;">Valor UF</th>
                    <th style="width:20%;">Tasa Anual (Referencial)</th>
                </tr>
                </thead>
                <tbody>   
                <tr class="table" style="text-align: right;  ">
                    <td style="width:40%;"><small><?php echo $hoy;?></small></td>
                    <td style="width:20%;">$<span data-bs-toggle="tooltip" title="Valor de la uf del día en curso" id="uf_dia_dt"><?php echo is_null($uf_actual) ? '' : $uf_actual; ?></span></td>
                    <td style="width:20%;"><span data-bs-toggle="tooltip" title="La tasa es solo referencial. Las condiciones dependen de tu banco." id="tasa">5,6%</span></td>
                </tr>
                </tbody>
            </table>
        </div>   
    </div>

    <div class="accordion" id="accordionExample">
  <div class="accordion-item accordion-item border border-4 border-dark">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Programa 2D + 2B
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseA1">
       <b class="card-title">Tipología A1</b>
      </a>
    </div>
    <div id="collapseA1" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
      <div id="select">
        <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A1"){
                    $departamentosA1[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | ".$resource["productos_cantidad_dormitorios"]."D + ".$resource["productos_cantidad_banios"]."B | UF ".$resource["productos_precio_lista"]." | ".$resource["productos_orientacion"]." | ".$resource["productos_superficie_comercial"];
                }
        }?>

            <div class="row">
            <div class="col-12 col-md-12">
            <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A1"){
                    echo "<center><img id='url_imgA1' class='img-fluid' width='650' height='450' src='".$resource["productos_url_planta"]."'></img></center>";
                    break;
                }
            }?>
            </div>
            <div class="col-12 col-md-6">
            <label for="departamento">Departamentos:  </label>
            <select data-bs-toggle="tooltip" title="Departamentos disponibles en el proyecto seleccionado."  id="departamentoA1" class="form-select selectcito" name="nombre_proyecto">
                <option value="0">Seleccione Departamento<option>
            <?php
                    foreach(array_unique($departamentosA1) as $val) {
                        echo "<option value='".$val."'>".$val."</option>";
            }?>
            </select>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Estacionamiento?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('A1');" name="radioEstacionamientoA1" id="estaRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('A1');" name="radioEstacionamientoA1" id="estaRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectEstA1" class="d-none">   
                    <label for="estacionamiento">Estacionamiento:  </label>
                    <select data-bs-toggle="tooltip" title="Estacionamientos disponibles en el proyecto seleccionado." id="estacionamientoA1" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Estacionamiento<option>
                    <?php
                            foreach(array_unique($estacionamientos) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Bodega?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('A1');" name="radioBodegaA1" id="bodRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('A1');" name="radioBodegaA1" id="bodRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectBodA1" class="d-none">  
                    <label for="bodega">Bodega: </label>
                    <select data-bs-toggle="tooltip" title="Bodegas disponibles en el proyecto seleccionado." id="bodegaA1" class="form-select selectcito" name="nombre_proyecto">
                        <option  value="0">Seleccione Bodega<option>
                    <?php
                            foreach(array_unique($bodegas) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-6">
                    <label for="nombre">Nombre y Apellido: </label>
                    <input value="<?php echo isset($session_data[0]['nombre_cliente']) ? ucwords($session_data[0]['nombre_cliente']) : '';?>" maxlength="100" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)" data-bs-toggle="tooltip" title="Por favor escribe tu nombre completo." id="nombre_completoA1" class="form-control nombreCotizante" name="nombre_proyecto">
                </div>
                <div class="col-12 col-md-6">
                    <label for="rut">RUT: </label>
                    <input value="<?php echo isset($session_data[0]['rut_cliente']) ? ($session_data[0]['rut_cliente']) : '';?>" maxlength="12" data-bs-toggle="tooltip" title="Por favor escribe tu Rut" id="rutA1" class="form-control rut" name="nombre_proyecto">
                </div>
                </div>
                <br>
            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="email">E-mail: </label>
                    <input maxlength="100" value="<?php echo isset($session_data[0]['email']) ? ($session_data[0]['email']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode == 64) || (event.charCode == 45) || (event.charCode == 95) || (event.charCode >= 46) || (event.charCode >= 241))" data-bs-toggle="tooltip" title="Por favor escribe tu E-mail, por este medio nos contactaremos contigo." id="emailA1" class="form-control emailCotizante" name="nombre_proyecto">
                </div>

                <div class="col-12 col-md-4">
                    <label for="email">Teléfono: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['telefono1']) ? ($session_data[0]['telefono1']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 43))" data-bs-toggle="tooltip" title="Por favor escribe tu teléfono, por este medio nos contactaremos contigo." id="telefonoA1" class="form-control telefonoCotizante" name="nombre_proyecto" value="+569">
                </div>

                <div class="col-12 col-md-4">
                <label for="inv-vi">¿Invertir o Vivir? </label>
                <select data-bs-toggle="tooltip" title="Desear vivir o invertir con nuestros productos." id="invertir_vivirA1" class="form-select selectcito" name="nombre_proyecto">
                    <option  value="1">Vivir</option>
                    <option  value="2">Invertir</option>
                </select>
                </div>
                </div>

                <br>
                <div class="row">
                    <div class="v-center d-grid gap-1 col-6 mx-auto">
                        <a href="#contenido" id="check_varsA1" class="btn btn-dark check_vars">Cotizar</a>
                    </div>
                </div>
                <!-- <a href="#contenido" id="check_varsA1" class="btn btn-light check_vars">Cotizar</a> -->
                <br>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseA2">
      <b class="card-title">Tipología A2</b>
      </a>
    </div>
    <div id="collapseA2" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
       <div id="select">
       <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A2"){
                    $departamentosA2[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | ".$resource["productos_cantidad_dormitorios"]."D + ".$resource["productos_cantidad_banios"]."B | UF ".$resource["productos_precio_lista"]." | ".$resource["productos_orientacion"]." | ".$resource["productos_superficie_comercial"];
                }
        }?>

            <div class="row">
            <div class="col-12 col-md-12">
            <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A2"){
                    echo "<center><img id='url_imgA2' class='img-fluid' width='650' height='450' src='".$resource["productos_url_planta"]."'></img></center>";
                    break;
                }
            }?>
            </div>
            <div class="col-12 col-md-6">
            <label for="departamento">Departamentos:  </label>
            <select data-bs-toggle="tooltip" title="Departamentos disponibles en el proyecto seleccionado." id="departamentoA2" class="form-select selectcito departamento" name="nombre_proyecto">
                <option value="0">Seleccione Departamento<option>
            <?php
                    foreach(array_unique($departamentosA2) as $val) {
                        echo "<option value='".$val."'>".$val."</option>";
            }?>
            </select>
            </div>

            <div class="col-md-6">
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Estacionamiento?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('A2');" name="radioEstacionamientoA2" id="estaRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('A2');" name="radioEstacionamientoA2" id="estaRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectEstA2" class="d-none">   
                    <label for="estacionamiento">Estacionamiento:  </label>
                    <select data-bs-toggle="tooltip" title="Estacionamientos disponibles en el proyecto seleccionado." id="estacionamientoA2" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Estacionamiento<option>
                    <?php
                            foreach(array_unique($estacionamientos) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Bodega?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('A2');" name="radioBodegaA2" id="bodRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('A2');" name="radioBodegaA2" id="bodRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectBodA2" class="d-none">  
                    <label for="bodega">Bodega: </label>
                    <select data-bs-toggle="tooltip" title="Bodegas disponibles en el proyecto seleccionado." id="bodegaA2" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Bodega<option>
                    <?php
                            foreach(array_unique($bodegas) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-6">
                    <label for="nombre">Nombre y Apellido: </label>
                    <input value="<?php echo isset($session_data[0]['nombre_cliente']) ? ucwords($session_data[0]['nombre_cliente']) : '';?>" maxlength="100" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)" data-bs-toggle="tooltip" title="Por favor escribe tu nombre completo." id="nombre_completoA2" class="form-control nombreCotizante" name="nombre_proyecto">
                </div>
                <div class="col-md-6">
                    <label for="rut">RUT: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['rut_cliente']) ? ($session_data[0]['rut_cliente']) : '';?>" data-bs-toggle="tooltip" title="Por favor escribe tu Rut" id="rutA2" class="form-control rut" name="nombre_proyecto">
                </div>
                </div>
                <br>
            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="email">E-mail: </label>
                    <input maxlength="100"  value="<?php echo isset($session_data[0]['email']) ? ($session_data[0]['email']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode == 64) || (event.charCode == 45) || (event.charCode == 95) || (event.charCode >= 46) || (event.charCode >= 241))" data-bs-toggle="tooltip" title="Por favor escribe tu E-mail, por este medio nos contactaremos contigo." id="emailA2" class="form-control emailCotizante" name="nombre_proyecto">
                </div>

                <div class="col-12 col-md-4">
                    <label for="email">Teléfono: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['telefono1']) ? ($session_data[0]['telefono1']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 43))" data-bs-toggle="tooltip" title="Por favor escribe tu teléfono, por este medio nos contactaremos contigo." id="telefonoA2" class="form-control telefonoCotizante" name="nombre_proyecto" value="+569">
                </div>

                <div class="col-12 col-md-4">
                <label for="inv-vi">¿Invertir o Vivir? </label>
                <select data-bs-toggle="tooltip" title="Desear vivir o invertir con nuestros productos." id="invertir_vivirA2" class="form-select selectcito" name="nombre_proyecto">
                    <option  value="1">Vivir</option>
                    <option  value="2">Invertir</option>
                </select>
                </div>
                </div>
                <br>
                <div class="row">
                    <div class="v-center d-grid gap-1 col-6 mx-auto">
                        <a href="#contenido" id="check_varsA2" class="btn btn-dark check_vars">Cotizar</a>
                    </div>
                </div>
                <!-- <a href="#contenido" id="check_varsA2" class="btn btn-light check_vars">Cotizar</a> -->
                <br>
       </div>
      </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseA4">
      <b class="card-title">Tipología A4</b>
      </a>
    </div>
    <div id="collapseA4" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
       <div id="select">
       <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A4"){
                    $departamentosA4[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | ".$resource["productos_cantidad_dormitorios"]."D + ".$resource["productos_cantidad_banios"]."B | UF ".$resource["productos_precio_lista"]." | ".$resource["productos_orientacion"]." | ".$resource["productos_superficie_comercial"];
                }
        }?>
        
            <div class="row">
            <div class="col-12 col-md-12">
            <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A4"){
                    echo "<center><img id='url_imgA4' width='650' height='450' src='".$resource["productos_url_planta"]."'></img></center>";
                    break;
                }
            }?>
            </div>
            <div class="col-12 col-md-6">
            <label for="departamento">Departamentos:  </label>
            <select data-bs-toggle="tooltip" title="Departamentos disponibles en el proyecto seleccionado."  id="departamentoA4" class="form-select selectcito departamento" name="nombre_proyecto">
                <option value="0">Seleccione Departamento<option>
            <?php
                    foreach(array_unique($departamentosA4) as $val) {
                        echo "<option value='".$val."'>".$val."</option>";
            }?>
            </select>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Estacionamiento?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('A4');" name="radioEstacionamientoA4" id="estaRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('A4');" name="radioEstacionamientoA4" id="estaRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectEstA4" class="d-none">   
                    <label for="estacionamiento">Estacionamiento:  </label>
                    <select data-bs-toggle="tooltip" title="Estacionamientos disponibles en el proyecto seleccionado." id="estacionamientoA4" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Estacionamiento<option>
                    <?php
                            foreach(array_unique($estacionamientos) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Bodega?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('A4');" name="radioBodegaA4" id="bodRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('A4');" name="radioBodegaA4" id="bodRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectBodA4" class="d-none">  
                    <label for="bodega">Bodega: </label>
                    <select data-bs-toggle="tooltip" title="Bodegas disponibles en el proyecto seleccionado." id="bodegaA4" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Bodega<option>
                    <?php
                            foreach(array_unique($bodegas) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-6">
                    <label for="nombre">Nombre y Apellido: </label>
                    <input value="<?php echo isset($session_data[0]['nombre_cliente']) ? ucwords($session_data[0]['nombre_cliente']) : '';?>" maxlength="100" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)" data-bs-toggle="tooltip" title="Por favor escribe tu nombre completo." id="nombre_completoA4" class="form-control nombreCotizante" name="nombre_proyecto">
                </div>
                <div class="col-12 col-md-6">
                    <label for="rut">RUT: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['rut_cliente']) ? ($session_data[0]['rut_cliente']) : '';?>" data-bs-toggle="tooltip" title="Por favor escribe tu Rut" id="rutA4" class="form-control rut" name="nombre_proyecto">
                </div>
                </div>
                <br>
            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="email">E-mail: </label>
                    <input maxlength="100"  value="<?php echo isset($session_data[0]['email']) ? ($session_data[0]['email']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode == 64) || (event.charCode == 45) || (event.charCode == 95) || (event.charCode >= 46) || (event.charCode >= 241))" data-bs-toggle="tooltip" title="Por favor escribe tu E-mail, por este medio nos contactaremos contigo." id="emailA4" class="form-control emailCotizante" name="nombre_proyecto">
                </div>

                <div class="col-12 col-md-4">
                    <label for="email">Teléfono: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['telefono1']) ? ($session_data[0]['telefono1']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 43))" data-bs-toggle="tooltip" title="Por favor escribe tu teléfono, por este medio nos contactaremos contigo." id="telefonoA4" class="form-control telefonoCotizante" name="nombre_proyecto" value="+569">
                </div>

                <div class="col-12 col-md-4">
                <label for="inv-vi">¿Invertir o Vivir? </label>
                <select data-bs-toggle="tooltip" title="Desear vivir o invertir con nuestros productos." id="invertir_vivirA4" class="form-select selectcito" name="nombre_proyecto">
                    <option  value="1">Vivir</option>
                    <option  value="2">Invertir</option>
                </select>
                </div>
                </div>

                <br>
                <div class="row">
                    <div class="v-center d-grid gap-1 col-6 mx-auto">
                        <a href="#contenido" id="check_varsA4" class="btn btn-dark check_vars">Cotizar</a>
                    </div>
                </div>
                <!-- <a href="#contenido" id="check_varsA4" class="btn btn-light check_vars">Cotizar</a> -->
                <br>
       </div>
      </div>
    </div>
</div>

      </div>
    </div>
  </div>
  <div class="accordion-item accordion-item border border-4 border-dark">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Programa 1D + 2B
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseB">
      <b class="card-title">Tipología B</b>
      </a>
    </div>
    <div id="collapseB" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
       <div id="select">
       <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "B"){
                    $departamentosB[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | ".$resource["productos_cantidad_dormitorios"]."D + ".$resource["productos_cantidad_banios"]."B | UF ".$resource["productos_precio_lista"]." | ".$resource["productos_orientacion"]." | ".$resource["productos_superficie_comercial"];
                }
        }?>

            <div class="row">
            <div class="col-12 col-md-12">
            <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "B"){
                    echo "<center><img id='url_imgB' class='img-fluid' width='650' height='450' src='".$resource["productos_url_planta"]."'></img></center>";
                    break;
                }
            }?>
            </div>
            <div class="col-12 col-md-6">
            <label for="departamento">Departamentos:  </label>
            <select data-bs-toggle="tooltip" title="Departamentos disponibles en el proyecto seleccionado." id="departamentoB" class="form-select selectcito departamento" name="nombre_proyecto">
                <option value="0">Seleccione Departamento<option>
            <?php
                    foreach(array_unique($departamentosB) as $val) {
                        echo "<option value='".$val."'>".$val."</option>";
            }?>
            </select>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Estacionamiento?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('B');" name="radioEstacionamientoB" id="estaRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('B');" name="radioEstacionamientoB" id="estaRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectEstB" class="d-none">   
                    <label for="estacionamiento">Estacionamiento:  </label>
                    <select data-bs-toggle="tooltip" title="Estacionamientos disponibles en el proyecto seleccionado." id="estacionamientoB" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Estacionamiento<option>
                    <?php
                            foreach(array_unique($estacionamientos) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Bodega?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('B');" name="radioBodegaB" id="bodRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('B');" name="radioBodegaB" id="bodRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectBodB" class="d-none">  
                    <label for="bodega">Bodega: </label>
                    <select data-bs-toggle="tooltip" title="Bodegas disponibles en el proyecto seleccionado." id="bodegaB" class="form-select selectcito" name="nombre_proyecto">
                        <option  value="0">Seleccione Bodega<option>
                    <?php
                            foreach(array_unique($bodegas) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-6">
                    <label for="nombre">Nombre y Apellido: </label>
                    <input value="<?php echo isset($session_data[0]['nombre_cliente']) ? ucwords($session_data[0]['nombre_cliente']) : '';?>" maxlength="100" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)" data-bs-toggle="tooltip" title="Por favor escribe tu nombre completo." id="nombre_completoB" class="form-control nombreCotizante" name="nombre_proyecto">
                </div>
                <div class="col-12 col-md-6">
                    <label for="rut">RUT: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['rut_cliente']) ? ($session_data[0]['rut_cliente']) : '';?>" data-bs-toggle="tooltip" title="Por favor escribe tu Rut" id="rutB" class="form-control rut" name="nombre_proyecto">
                </div>
                </div>
                <br>
            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="email">E-mail: </label>
                    <input maxlength="100"  value="<?php echo isset($session_data[0]['email']) ? ($session_data[0]['email']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode == 64) || (event.charCode == 45) || (event.charCode == 95) || (event.charCode >= 46) || (event.charCode >= 241))" data-bs-toggle="tooltip" title="Por favor escribe tu E-mail, por este medio nos contactaremos contigo." id="emailB" class="form-control emailCotizante" name="nombre_proyecto">
                </div>

                <div class="col-12 col-md-4">
                    <label for="email">Teléfono: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['telefono1']) ? ($session_data[0]['telefono1']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 43))" data-bs-toggle="tooltip" title="Por favor escribe tu teléfono, por este medio nos contactaremos contigo." id="telefonoB" class="form-control telefonoCotizante" name="nombre_proyecto" value="+569">
                </div>

                <div class="col-12 col-md-4">
                <label for="inv-vi">¿Invertir o Vivir? </label>
                <select data-bs-toggle="tooltip" title="Desear vivir o invertir con nuestros productos." id="invertir_vivirB" class="form-select selectcito" name="nombre_proyecto">
                    <option  value="1">Vivir</option>
                    <option  value="2">Invertir</option>
                </select>
                </div>
                </div>

                <br>
                <div class="row">
                    <div class="v-center d-grid gap-1 col-6 mx-auto">
                        <a href="#contenido" id="check_varsB" class="btn btn-dark check_vars">Cotizar</a>
                    </div>
                </div>
                <!-- <a href="#contenido" id="check_varsB" class="btn btn-light check_vars">Cotizar</a> -->
                <br>
       </div>
      </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseA3">
      <b class="card-title">Tipología A3</b>
      </a>
    </div>
    <div id="collapseA3" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
       <div id="select">
       <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A3"){
                    $departamentosA3[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | ".$resource["productos_cantidad_dormitorios"]."D + ".$resource["productos_cantidad_banios"]."B | UF ".$resource["productos_precio_lista"]." | ".$resource["productos_orientacion"]." | ".$resource["productos_superficie_comercial"];
                }
        }?>

            <div class="row">
            <div class="col-12 col-md-12">
            <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "A3"){
                    echo "<center><img id='url_imgA3' class='img-fluid' width='650' height='450' src='".$resource["productos_url_planta"]."'></img></center>";
                    break;
                }
            }?>
            </div>
            <div class="col-12 col-md-6">
            <label for="departamento">Departamentos:  </label>
            <select data-bs-toggle="tooltip" title="Departamentos disponibles en el proyecto seleccionado." id="departamentoA3" class="form-select selectcito departamento" name="nombre_proyecto">
                <option value="0">Seleccione Departamento<option>
            <?php
                    foreach(array_unique($departamentosA3) as $val) {
                        echo "<option value='".$val."'>".$val."</option>";
            }?>
            </select>
            </div>

            <div class="col-md-6">
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Estacionamiento?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('A3');" name="radioEstacionamientoA3" id="estaRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('A3');" name="radioEstacionamientoA3" id="estaRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectEstA3" class="d-none">   
                    <label for="estacionamiento">Estacionamiento:  </label>
                    <select data-bs-toggle="tooltip" title="Estacionamientos disponibles en el proyecto seleccionado." id="estacionamientoA3" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Estacionamiento<option>
                    <?php
                            foreach(array_unique($estacionamientos) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Bodega?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('A3');" name="radioBodegaA3" id="bodRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('A3');" name="radioBodegaA3" id="bodRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectBodA3" class="d-none">  
                    <label for="bodega">Bodega: </label>
                    <select data-bs-toggle="tooltip" title="Bodegas disponibles en el proyecto seleccionado." id="bodegaA3" class="form-select selectcito" name="nombre_proyecto">
                        <option  value="0">Seleccione Bodega<option>
                    <?php
                            foreach(array_unique($bodegas) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-6">
                    <label for="nombre">Nombre y Apellido: </label>
                    <input value="<?php echo isset($session_data[0]['nombre_cliente']) ? ucwords($session_data[0]['nombre_cliente']) : '';?>" maxlength="100" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)" data-bs-toggle="tooltip" title="Por favor escribe tu nombre completo." id="nombre_completoA3" class="form-control nombreCotizante" name="nombre_proyecto">
                </div>
                <div class="col-12 col-md-6">
                    <label for="rut">RUT: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['rut_cliente']) ? ($session_data[0]['rut_cliente']) : '';?>" data-bs-toggle="tooltip" title="Por favor escribe tu Rut" id="rutA3" class="form-control rut" name="nombre_proyecto">
                </div>
                </div>
                <br>
            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="email">E-mail: </label>
                    <input maxlength="100"  value="<?php echo isset($session_data[0]['email']) ? ($session_data[0]['email']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode == 64) || (event.charCode == 45) || (event.charCode == 95) || (event.charCode >= 46) || (event.charCode >= 241))" data-bs-toggle="tooltip" title="Por favor escribe tu E-mail, por este medio nos contactaremos contigo." id="emailA3" class="form-control emailCotizante" name="nombre_proyecto">
                </div>

                <div class="col-12 col-md-4">
                    <label for="email">Teléfono: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['telefono1']) ? ($session_data[0]['telefono1']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 43))" data-bs-toggle="tooltip" title="Por favor escribe tu teléfono, por este medio nos contactaremos contigo." id="telefonoA3" class="form-control telefonoCotizante" name="nombre_proyecto" value="+569">
                </div>

                <div class="col-12 col-md-4">
                <label for="inv-vi">¿Invertir o Vivir? </label>
                <select data-bs-toggle="tooltip" title="Desear vivir o invertir con nuestros productos." id="invertir_vivirA3" class="form-select selectcito" name="nombre_proyecto">
                    <option  value="1">Vivir</option>
                    <option  value="2">Invertir</option>
                </select>
                </div>
                </div>

                <br>
                <div class="row">
                    <div class="v-center d-grid gap-1 col-6 mx-auto">
                        <a href="#contenido" id="check_varsA3" class="btn btn-dark check_vars">Cotizar</a>
                    </div>
                </div>
                <!-- <a href="#contenido" id="check_varsA3" class="btn btn-light check_vars">Cotizar</a> -->
                <br>
       </div>
      </div>
    </div>
</div>

      </div>
    </div>
  </div>
  <div class="accordion-item accordion-item border border-4 border-dark">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Programa 3D + 3B
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseD">
      <b class="card-title">Tipología D</b>
      </a>
    </div>
    <div id="collapseD" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
       <div id="select">
       <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "D"){
                    $departamentosD[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | ".$resource["productos_cantidad_dormitorios"]."D + ".$resource["productos_cantidad_banios"]."B | UF ".$resource["productos_precio_lista"]." | ".$resource["productos_orientacion"]." | ".$resource["productos_superficie_comercial"];
                }
        }?>

            <div class="row">
            <div class="col-12 col-md-12">
            <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "D"){
                    echo "<center><img id='url_imgD'  class='img-fluid' width='650' height='450' src='".$resource["productos_url_planta"]."'></img></center>";
                    break;
                }
            }?>
            </div>
            <div class="col-12 col-md-6">
            <label for="departamento">Departamentos:  </label>
            <select data-bs-toggle="tooltip" title="Departamentos disponibles en el proyecto seleccionado." id="departamentoD" class="form-select selectcito departamento" name="nombre_proyecto">
                <option value="0">Seleccione Departamento<option>
            <?php
                    foreach(array_unique($departamentosD) as $val) {
                        echo "<option value='".$val."'>".$val."</option>";
            }?>
            </select>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Estacionamiento?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('D');" name="radioEstacionamientoD" id="estaRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('D');" name="radioEstacionamientoD" id="estaRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectEstD" class="d-none">   
                    <label for="estacionamiento">Estacionamiento:  </label>
                    <select data-bs-toggle="tooltip" title="Estacionamientos disponibles en el proyecto seleccionado." id="estacionamientoD" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Estacionamiento<option>
                    <?php
                            foreach(array_unique($estacionamientos) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
            </select>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Bodega?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('D');" name="radioBodegaD" id="bodRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('D');" name="radioBodegaD" id="bodRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectBodD" class="d-none">  
                    <label for="bodega">Bodega: </label>
                    <select data-bs-toggle="tooltip" title="Bodegas disponibles en el proyecto seleccionado." id="bodegaD" class="form-select selectcito" name="nombre_proyecto">
                        <option  value="0">Seleccione Bodega<option>
                    <?php
                            foreach(array_unique($bodegas) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-6">
                    <label for="nombre">Nombre y Apellido: </label>
                    <input value="<?php echo isset($session_data[0]['nombre_cliente']) ? ucwords($session_data[0]['nombre_cliente']) : '';?>" maxlength="100" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)" data-bs-toggle="tooltip" title="Por favor escribe tu nombre completo." id="nombre_completoD" class="form-control nombreCotizante" name="nombre_proyecto">
                </div>
                <div class="col-12 col-md-6">
                    <label for="rut">RUT: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['rut_cliente']) ? ($session_data[0]['rut_cliente']) : '';?>" data-bs-toggle="tooltip" title="Por favor escribe tu Rut" id="rutD" class="form-control rut" name="nombre_proyecto">
                </div>
                </div>
                <br>
            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="email">E-mail: </label>
                    <input maxlength="100"  value="<?php echo isset($session_data[0]['email']) ? ($session_data[0]['email']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode == 64) || (event.charCode == 45) || (event.charCode == 95) || (event.charCode >= 46) || (event.charCode >= 241))" data-bs-toggle="tooltip" title="Por favor escribe tu E-mail, por este medio nos contactaremos contigo." id="emailD" class="form-control emailCotizante" name="nombre_proyecto">
                </div>

                <div class="col-12 col-md-4">
                    <label for="email">Teléfono: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['telefono1']) ? ($session_data[0]['telefono1']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 43))" data-bs-toggle="tooltip" title="Por favor escribe tu teléfono, por este medio nos contactaremos contigo." id="telefonoD" class="form-control telefonoCotizante" name="nombre_proyecto" value="+569">
                </div>

                <div class="col-12 col-md-4">
                <label for="inv-vi">¿Invertir o Vivir? </label>
                <select data-bs-toggle="tooltip" title="Desear vivir o invertir con nuestros productos." id="invertir_vivirD" class="form-select selectcito" name="nombre_proyecto">
                    <option  value="1">Vivir</option>
                    <option  value="2">Invertir</option>
                </select>
                </div>
                </div>

                <br>
                <div class="row">
                    <div class="v-center d-grid gap-1 col-6 mx-auto">
                        <a href="#contenido" id="check_varsD" class="btn btn-dark check_vars">Cotizar</a>
                    </div>
                </div>
                <!-- <a href="#contenido" id="check_varsD" class="btn btn-light check_vars">Cotizar</a> -->
                <br>
       </div>
      </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#collapseC3">
      <b class="card-title">Tipología C3</b>
      </a>
    </div>
    <div id="collapseC3" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
       <div id="select">
       <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "C3"){
                    $departamentosC3[] = $resource["productos_id"]." | ".$resource["productos_nombre"]." | ".$resource["productos_tipo"]." | ".$resource["productos_cantidad_dormitorios"]."D + ".$resource["productos_cantidad_banios"]."B | UF ".$resource["productos_precio_lista"]." | ".$resource["productos_orientacion"]." | ".$resource["productos_superficie_comercial"];
                }
        }?>
            <div class="row">
            <div class="col-12 col-md-12">
            <?php 
            foreach($decoded_json as $rkey => $resource) {
                    if($resource["productos_tipo_unidad"] == "Departamento" && $resource["productos_tipo"] == "C3"){
                    echo "<center><img id='url_imgC3' class='img-fluid' width='650' height='450' src='".$resource["productos_url_planta"]."'></img></center>";
                    break;
                }
            }?>
            </div>
            <div class="col-12 col-md-6">
            <label for="departamento">Departamentos:  </label>
            <select data-bs-toggle="tooltip" title="Departamentos disponibles en el proyecto seleccionado."  id="departamentoC3" class="form-select selectcito departamento" name="nombre_proyecto">
                <option value="0">Seleccione Departamento<option>
            <?php
                    foreach(array_unique($departamentosC3) as $val) {
                        echo "<option value='".$val."'>".$val."</option>";
            }?>
            </select>
            </div>

            <div class="col-md-6">
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Estacionamiento?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('C3');" name="radioEstacionamientoC3" id="estaRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" onchange="despliegaEstacionamiento('C3');" name="radioEstacionamientoC3" id="estaRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectEstC3" class="d-none">   
                    <label for="estacionamiento">Estacionamiento:  </label>
                    <select data-bs-toggle="tooltip" title="Estacionamientos disponibles en el proyecto seleccionado." id="estacionamientoC3" class="form-select selectcito" name="nombre_proyecto">
                        <option value="0">Seleccione Estacionamiento<option>
                    <?php
                            foreach(array_unique($estacionamientos) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <label for="estacionamiento">¿Deseas Bodega?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('B2');" name="radioBodegaB2" id="bodRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input classRadioBod" type="radio" onchange="despliegaBodega('B2');" name="radioBodegaB2" id="bodRadio2" value="0" checked>
                    <label class="form-check-label" for="inlineRadio2">No</label>
                </div>
            </div>
            <div class="col-md-6">
                <div id="divSelectBodC3" class="d-none">  
                    <label for="bodega">Bodega: </label>
                    <select data-bs-toggle="tooltip" title="Bodegas disponibles en el proyecto seleccionado." id="bodegaC3" class="form-select selectcito" name="nombre_proyecto">
                        <option  value="0">Seleccione Bodega<option>
                    <?php
                            foreach(array_unique($bodegas) as $val) {
                                echo "<option value='".$val."'>".$val."</option>";
                    }?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            </div>
            <div class="row">
            <div class="col-12 col-md-6">
                    <label for="nombre">Nombre y Apellido: </label>
                    <input value="<?php echo isset($session_data[0]['nombre_cliente']) ? ucwords($session_data[0]['nombre_cliente']) : '';?>" maxlength="100" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)" data-bs-toggle="tooltip" title="Por favor escribe tu nombre completo." id="nombre_completoC3" class="form-control nombreCotizante" name="nombre_proyecto">
                </div>
                <div class="col-12 col-md-6">
                    <label for="rut">RUT: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['rut_cliente']) ? ($session_data[0]['rut_cliente']) : '';?>" data-bs-toggle="tooltip" title="Por favor escribe tu Rut" id="rutC3" class="form-control rut" name="nombre_proyecto">
                </div>
                </div>
                <br>
            <div class="row">
                <div class="col-12 col-md-4">
                    <label for="email">E-mail: </label>
                    <input maxlength="100"  value="<?php echo isset($session_data[0]['email']) ? ($session_data[0]['email']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode == 64) || (event.charCode == 45) || (event.charCode == 95) || (event.charCode >= 46) || (event.charCode >= 241))" data-bs-toggle="tooltip" title="Por favor escribe tu E-mail, por este medio nos contactaremos contigo." id="emailC3" class="form-control emailCotizante" name="nombre_proyecto">
                </div>

                <div class="col-12 col-md-4">
                    <label for="email">Teléfono: </label>
                    <input maxlength="12" value="<?php echo isset($session_data[0]['telefono1']) ? ($session_data[0]['telefono1']) : '';?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 43))" data-bs-toggle="tooltip" title="Por favor escribe tu teléfono, por este medio nos contactaremos contigo." id="telefonoC3" class="form-control telefonoCotizante" name="nombre_proyecto" value="+569">
                </div>

                <div class="col-12 col-md-4">
                <label for="inv-vi">¿Invertir o Vivir? </label>
                <select data-bs-toggle="tooltip" title="Desear vivir o invertir con nuestros productos." id="invertir_vivirC3" class="form-select selectcito" name="nombre_proyecto">
                    <option  value="1">Vivir</option>
                    <option  value="2">Invertir</option>
                </select>
                </div>
                </div>

                <br>
                <div class="row">
                    <div class="v-center d-grid gap-1 col-6 mx-auto">
                        <a href="#contenido" id="check_varsC3" class="btn btn-dark check_vars">Cotizar</a>
                    </div>
                </div>
                <!-- <a href="#contenido" id="check_varsC3" class="btn btn-light check_vars">Cotizar</a> -->
                <br>
       </div>
      </div>
    </div>
</div>


      </div>
    </div>
  </div>
</div>
<br>
<script type="text/javascript">
    const formatNumberES = (n, d=0) => {
        n=new Intl.NumberFormat("es-ES").format(parseFloat(n).toFixed(d))
        if (d>0) {
            // Obtenemos la cantidad de decimales que tiene el numero
            const decimals=n.indexOf(",")>-1 ? n.length-1-n.indexOf(",") : 0;
    
            // añadimos los ceros necesios al numero
            n = (decimals==0) ? n+","+"0".repeat(d) : n+"0".repeat(d-decimals);
        }
        return n;
    }
</script>
<!-- RESPUESTA DE FUNCION AJAX - CHECKOUT.PHP -->
<div id="contenido">
</div>
<!--  FIN RESPUESTA DE FUNCION AJAX - CHECKOUT.PHP -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JavaScript Bundle with Popper -->
<script src="../js/jquery.rut.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://kit.fontawesome.com/f5939545a8.js" crossorigin="anonymous"></script>
<script src="../assets/js/sidebar.js"></script> 
<script>
function validacion_cotizar(depto, nombre_completo, rut, email, telefono, invertir_vivir, id){
    var validacion = false
    var campos_vacios = true
    const estacionamiento = $('input[type=radio][name=radioEstacionamiento' + id + ']:checked').val();
    const bodega = $('input[type=radio][name=radioBodega' + id + ']:checked').val();
    if (estacionamiento == '1') {
        const valEstacionamiento = $('#estacionamiento' + id).val();
        if (valEstacionamiento == "0" || valEstacionamiento == undefined || valEstacionamiento == "") {
            const divEsta = $('#estacionamiento' + id).parent();
            select_esta = divEsta.find("span > span.selection > span")
            $(select_esta).css('border', '1px solid red');
            campos_vacios = false
        }else{
            const divEsta = $('#estacionamiento' + id).parent();
            select_esta = divEsta.find("span > span.selection > span")
            $(select_esta).css('border', '1px solid green');
        }
    }
    if (bodega == '1') {
        const valBodega = $('#bodega' + id).val();
        if (valBodega == "0" || valBodega == undefined || valBodega == "") {
            const divBod = $('#bodega' + id).parent();
            select_bod = divBod.find("span > span.selection > span")
            $(select_bod).css('border', '1px solid red');
            campos_vacios = false
        }else{
            const divBod = $('#bodega' + id).parent();
            select_bod = divBod.find("span > span.selection > span")
            $(select_bod).css('border', '1px solid green');
        }
    }
    if (depto == 0 || depto == undefined || depto == "") {  
        const divSelect = $('#departamento' + id).parent();
        select_depto = divSelect.find("span > span.selection > span")
        $(select_depto).css('border', '1px solid red');
        campos_vacios = false
    }else{
        const divSelect = $('#departamento' + id).parent();
        select_depto = divSelect.find("span > span.selection > span")
        $(select_depto).css('border', '1px solid green');
    }
    if (nombre_completo == "") {  
        $('#nombre_completo' + id).css('border', '1px solid red');
        campos_vacios = false
    }
    if (rut == "") {   
        $('#rut' + id).css('border', '1px solid red');
        campos_vacios = false
    }
    if (email == "") {  
        $('#email' + id).css('border', '1px solid red');
        campos_vacios = false
    }
    if (telefono == "+569" || telefono == "") {  
        $('#telefono' + id).css('border', '1px solid red');
        campos_vacios = false
    }

    if (!(campos_vacios)) {
        Swal.fire({
            position: 'middle-center',
            icon: 'error',
            title: 'Debes completar los campos marcados!',
            showConfirmButton: false,
            timer: 1500
        })
        
    }else{
        const bc_rut = $('#rut' + id).css('border-color');
        const bc_email = $('#email' + id).css('border-color');
        const bc_telefono = $('#telefono' + id).css('border-color');
        const bc_nombre_completo = $('#nombre_completo' + id).css('border-color');
        if (bc_rut == 'rgb(0, 128, 0)' && bc_email == 'rgb(0, 128, 0)' && bc_telefono == 'rgb(0, 128, 0)' && bc_nombre_completo == 'rgb(0, 128, 0)') {
            validacion = true;
        }else{
            Swal.fire({
                position: 'middle-center',
                icon: 'error',
                title: 'Debes completar correctamente los campos marcados!',
                showConfirmButton: false,
                timer: 1500
            })
        }
    }
    
    
    return validacion
}

function despliegaEstacionamiento(id){
    const value = $('input[type=radio][name=radioEstacionamiento' + id + ']:checked').val();
    if (value == '0') {
        $('#divSelectEst' + id).addClass('d-none');
        $('#estacionamiento' + id).val('0').select2();
    }
    else if (value == '1') {
        $('#divSelectEst' + id).removeClass('d-none');
    }
    
    
}

function despliegaBodega(id){
    const value = $('input[type=radio][name=radioBodega' + id + ']:checked').val();
    if (value == '0') {
        $('#divSelectBod' + id).addClass('d-none')
        $('#bodega' + id).val('0').select2();
    }
    else if (value == '1') {
        $('#divSelectBod' + id).removeClass('d-none');
    }
    
}
$(document).ready(function(){
    $('.selectcito').select2({
      width: 'resolve'
    });

    $('.nombreCotizante').on('input', function () {
        const value = $(this).val();
        var arr = value.split(' ');
        if(arr.length == 2){
            var valida_espacio = arr.includes('');
            if (valida_espacio) {
                $(this).css('border', '1px solid red');
                $(this).attr("onkeypress", "return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 209) || (event.charCode == 241)");
            }else{
                if (arr[0].length > 2 && arr[1].length > 2) {         
                    $(this).css('border', '1px solid green');
                    validacion = true;
                }else{
                    $(this).css('border', '1px solid red');
                }
            }
        }else{
            // alert('hola');
            if (value == "" || arr.length == 1) {
                $(this).attr("onkeypress", "return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)");
                $(this).css('border', '1px solid red');
            }else{
                $(this).css('border', '1px solid red');
            }
        }
    });

    $('.telefonoCotizante').on('input', function () {
        const value = $(this).val();
        var validacion = false; 
        if(value.length > 8 && value.length <= 12){
            $(this).css('border', '1px solid green');
        }else{
            $(this).css('border', '1px solid red');
        }
    });

    $('.emailCotizante').on('input', function () {
        const value = $(this).val();
        var validacion = false; 
        if(value.length >= 7){
            $(this).css('border', '1px solid green');
        }else{
            $(this).css('border', '1px solid red');
        }
    });

    <?php if(isset($session_data[0]['nombre_cliente'])){ ?>
        var value = "<?php echo $session_data[0]['nombre_cliente'] ?>";
        var arr = value.split(' ');
        if(arr.length == 2){
            var valida_espacio = arr.includes('');
            if (valida_espacio) {
                $('.nombreCotizante').css('border', '1px solid red');
                $('.nombreCotizante').attr("onkeypress", "return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 209) || (event.charCode == 241)");
            }else{
                if (arr[0].length > 2 && arr[1].length > 2) {         
                    $('.nombreCotizante').css('border', '1px solid green');
                    validacion = true;
                }else{
                    $('.nombreCotizante').css('border', '1px solid red');
                }
            }
        }else{
            // alert('hola');
            if (value == "" || arr.length == 1) {
                $('.nombreCotizante').attr("onkeypress", "return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)) || (event.charCode == 32) || (event.charCode == 209) || (event.charCode == 241)");
                $('.nombreCotizante').css('border', '1px solid red');
            }else{
                $('.nombreCotizante').css('border', '1px solid red');
            }
        }
    <?php } ?>
    <?php if(isset($session_data[0]['email'])){ ?>
        var value = "<?php echo $session_data[0]['email'] ?>";
        var validacion = false; 
        if(value.length >= 7){
            $('.emailCotizante').css('border', '1px solid green');
        }else{
            $('.emailCotizante').css('border', '1px solid red');
        }
    <?php } ?>
    <?php if(isset($session_data[0]['telefono1'])){ ?>
        var value = "<?php echo $session_data[0]['telefono1'] ?>";
        var validacion = false; 
        if(value.length > 8 && value.length <= 12){
            $('.telefonoCotizante').css('border', '1px solid green');
        }else{
            $('.telefonoCotizante').css('border', '1px solid red');
        }
    <?php } ?>
    <?php if(isset($session_data[0]['rut_cliente'])){ ?>
        $('.rut').css('border', '1px solid green');
    <?php } ?>
    <?php if(!(isset($_SESSION['rut']))){ ?>
        Swal.fire({
            title: '',
            imageUrl: '../assets/surmonte-logo-1.png',
            imageWidth: 140,
            imageHeight: 30,
            imageAlt: 'Logo surmonte',
            html: '<h5>¡Hola! Si quieres tener una experiencia mas rápida.</h5>'+
            '<form method="POST" action="https://salaventas.surmonte.cl/login.php" target="_blank"> '+
            '<input type="hidden" name="linkred" value="<?php echo ($escaped_link); ?>">'+
            '<a><button type="submit" style="background-color: transparent; color: blue" class="btn btn-light check_vars">¡Inicia sesión aquí!</button></a></form>',
            // '<button type="submit" style="background-color: rgb(255 151 53)" class="btn btn-light check_vars"></button><a href="http://localhost/flujocompra/login.php">¡Inicia sesión aquí!</a> ',
            showCloseButton: true,
            focusConfirm: false,
            confirmButtonColor: 'rgb(255 151 53)',
            
            confirmButtonText:
                'Continuar como Invitado',
            });
    <?php } ?>
});


var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
return new bootstrap.Tooltip(tooltipTriggerEl)
});

        $(".rut")
        .rut({formatOn: 'keyup', validateOn: 'keyup'})
        .on('rutInvalido', function(){ 
            $(this).css("border-color", "red");
            $(this).css("border-style", "solid");
        })
        .on('rutValido', function(){ 
            
            $(this).css("border-color", "green");
            $(this).css("border-style", "solid");
        });

        var date = new Date();
        var dd = String(date.getDate()).padStart(2, '0');
        var mm = String(date.getMonth() + 1).padStart(2, '0'); 
        var yyyy = date.getFullYear();
        date = dd + '-' + mm + '-' + yyyy;
        var uf_d;
        if ($("#uf_dia_dt").text() == '') {
            $.getJSON('https://mindicador.cl/api/uf/'+date, function(data) {
                if(data.serie[0].valor  != null ){
                      uf_d = data.serie[0].valor;
                      var uf_transformer = formatNumberES(uf_d, 2);
                      var uf = $("#uf_dia_dt").text(uf_transformer);
                      var uf = uf_d;
                }else{
                  $( "#cotizador-credito-valor-uf" ).focus(function() {
                      alert( "Handler for .focus() called." );
                  });
                } 
            });
        }else{
            uf_d = parseFloat($("#uf_dia_dt").text());
            var uf_transformer = formatNumberES(uf_d, 2);
            var uf = $("#uf_dia_dt").text(uf_transformer);
            var uf = uf_d;
        }
 

          $( "#check_varsA1" ).click(function() {
            
            var depto = $("#departamentoA1").val();
            var est = $("#estacionamientoA1").val();
            var bod = $("#bodegaA1").val();
            var nombre_completo = $("#nombre_completoA1").val();
            var rut = $("#rutA1").val();
            var email = $("#emailA1").val();
            var telefono = $("#telefonoA1").val();
            var invertir_vivir = $("#invertir_vivirA1").val();

            const validacionForm = validacion_cotizar(depto, nombre_completo, rut, email, telefono, invertir_vivir, 'A1');
            if (!(validacionForm)) {
                return false;
            }
      
            var depto_values = depto.split("|");

            if(est.length > 1)
            {
                var est_values = est.split("|");

            }else{

                var est = "0|0|0| UF 0";
                var est_values = est.split("|");
            }
            
            if(bod.length > 1)
            {
                var bod_values = bod.split("|");

            }else{

                var bod = "0|0|0| UF 0";
                var bod_values = bod.split("|");

            }

           
         

            var values_depto = depto_values[4].split(" ");
            var values_est = est_values[3].split(" ");
            var values_bod = bod_values[3].split(" ");
      

            var total_propiedad_uf = parseFloat(values_depto[2]) + parseInt(values_est[2]) + parseInt(values_bod[2]);


            //datos cliente
            var proyecto = $("#proyecto").text();
            

            var url_imagen = $('#url_imgA1').attr('src');

            var id_producto = {
                 0 : values_depto[2]+"|"+depto_values[0],
                 1 : values_est[2]+"|"+est_values[0],
                 2 : values_bod[2]+"|"+bod_values[0],   
            };
            var total_propiedad = parseInt(total_propiedad_uf * uf_d);
            var total_propiedad_uf = total_propiedad_uf;
            console.log(total_propiedad);
            var montoFormat = total_propiedad.toString().replace(/[$.]/g,'');
            var parsePropiedad = parseInt(montoFormat);
            var porcentaje_pie = 15;
            var pie = (parsePropiedad*porcentaje_pie)/100;
            var pie_uf = pie/uf_d;
            var years = 25
            var cuotas = years*12;
            var tasa_interes = 5.6
            var total_credito_uf = total_propiedad_uf - pie_uf;
            var total_credito_clp = total_credito_uf*uf_d;
            var interes_mensual = (tasa_interes/100) /12;
            var dividendo = total_credito_uf/(((1-(1 + interes_mensual) ** - cuotas ))/interes_mensual);
            var dividendo15 = (total_credito_uf/(((1-(1 + interes_mensual) ** -  180))/interes_mensual))*uf_d;
            var dividendo20 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 240 ))/interes_mensual))*uf_d;
            var dividendo25 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 300 ))/interes_mensual))*uf_d;
            var dividendo30 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 360 ))/interes_mensual))*uf_d;
            var total_credito_clp_uf = dividendo * uf_d;
            var renta_sugerida = total_credito_clp_uf * 3.8;
            
              $.ajax({
                url: '../checkout.php',
                type: 'POST',
                data: {
                  'url_imagen': url_imagen,
                  'proyecto' : "42LINARES",
                  'nombre_completo' : nombre_completo,
                  'rut': rut,
                  'email': email,
                  'telefono' : telefono,
                  'invertir_vivir' : invertir_vivir,
                  'id_producto': id_producto,
                  'depto': depto,
                  'est' : est,
                  'bod' : bod,
                  'total_propiedad_uf' : total_propiedad_uf,
                  'total_propiedad_clp' : montoFormat, 
                  'porcentaje_pie': porcentaje_pie, 
                  'pie_clp': pie.toFixed(0), 
                  'pie_uf': pie_uf.toFixed(0),
                  'cuotas': cuotas.toFixed(0), 
                  'years': years, 
                  'tasa_interes': tasa_interes,
                  'uf_dia': <?php echo $uf_actual?>,
                  'total_credito_uf': total_credito_uf,
                  'total_credito_clp': total_credito_clp,
                  'dividendo' : dividendo,
                  'total_credito_clp_uf' : total_credito_clp_uf,
                  'renta_sugerida': renta_sugerida,
                  'dividendo15': dividendo15,
                  'dividendo20': dividendo20,
                  'dividendo25': dividendo25,
                  'dividendo30': dividendo30},
                beforeSend: function(){
                    $('#loader').modal('show');
                },
                success: function (response) {
                   $('#loader').modal('hide');
                   $("#contenido").html(response);
                   $('html, body').animate({
                      scrollTop: $("#contenido").offset().top-70
                  }, 'slow');
                  return false;
                    }
          });
          }     
        );

        $( "#check_varsA2" ).click(function() {
            
            var depto = $("#departamentoA2").val();
            var est = $("#estacionamientoA2").val();
            var bod = $("#bodegaA2").val();
            var nombre_completo = $("#nombre_completoA2").val();
            var rut = $("#rutA2").val();
            var email = $("#emailA2").val();
            var telefono = $("#telefonoA2").val();
            var invertir_vivir = $("#invertir_vivirA2").val();
           
            const validacionForm = validacion_cotizar(depto, nombre_completo, rut, email, telefono, invertir_vivir, 'A2');
            if (!(validacionForm)) {
                return false;
            }

            var depto_values = depto.split("|");

            if(est.length > 1)
            {
                var est_values = est.split("|");

            }else{

                var est = "0|0|0| UF 0";
                var est_values = est.split("|");
            }
            
            if(bod.length > 1)
            {
                var bod_values = bod.split("|");

            }else{

                var bod = "0|0|0| UF 0";
                var bod_values = bod.split("|");

            }

         

            var values_depto = depto_values[4].split(" ");
            var values_est = est_values[3].split(" ");
            var values_bod = bod_values[3].split(" ");
          

            var total_propiedad_uf = parseFloat(values_depto[2]) + parseInt(values_est[2]) + parseInt(values_bod[2]);


            //datos cliente
            var proyecto = $("#proyecto").text();
            var url_imagen = $('#url_imgA2').attr('src');

            var id_producto = {
                0 : values_depto[2]+"|"+depto_values[0],
                1 : values_est[2]+"|"+est_values[0],
                2 : values_bod[2]+"|"+bod_values[0],   
            };

            var total_propiedad = parseInt(total_propiedad_uf * uf_d);
            var total_propiedad_uf = total_propiedad_uf;
            console.log(total_propiedad);
            var montoFormat = total_propiedad.toString().replace(/[$.]/g,'');
            var parsePropiedad = parseInt(montoFormat);
            var porcentaje_pie = 15;
            var pie = (parsePropiedad*porcentaje_pie)/100;
            var pie_uf = pie/uf_d;
            var years = 25
            var cuotas = years*12;
            var tasa_interes = 5.6
            var total_credito_uf = total_propiedad_uf - pie_uf;
            var total_credito_clp = total_credito_uf*uf_d;
            var interes_mensual = (tasa_interes/100) /12;
            var dividendo = total_credito_uf/(((1-(1 + interes_mensual) ** - cuotas ))/interes_mensual);
            var dividendo15 = (total_credito_uf/(((1-(1 + interes_mensual) ** -  180))/interes_mensual))*uf_d;
            var dividendo20 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 240 ))/interes_mensual))*uf_d;
            var dividendo25 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 300 ))/interes_mensual))*uf_d;
            var dividendo30 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 360 ))/interes_mensual))*uf_d;
            var total_credito_clp_uf = dividendo * uf_d;
            var renta_sugerida = total_credito_clp_uf * 3.8;
            
              $.ajax({
                url: '../checkout.php',
                type: 'POST',
                data: {
                  'url_imagen': url_imagen,
                  'proyecto' : "42LINARES",
                  'nombre_completo' : nombre_completo,
                  'rut': rut,
                  'email': email,
                  'telefono' : telefono,
                  'invertir_vivir' : invertir_vivir,
                  'id_producto': id_producto,
                  'depto': depto,
                  'est' : est,
                  'bod' : bod,
                  'total_propiedad_uf' : total_propiedad_uf,
                  'total_propiedad_clp' : montoFormat, 
                  'porcentaje_pie': porcentaje_pie, 
                  'pie_clp': pie.toFixed(0), 
                  'pie_uf': pie_uf.toFixed(0),
                  'cuotas': cuotas.toFixed(0), 
                  'years': years, 
                  'tasa_interes': tasa_interes,
                  'uf_dia': <?php echo $uf_actual?>,
                  'total_credito_uf': total_credito_uf,
                  'total_credito_clp': total_credito_clp,
                  'dividendo' : dividendo,
                  'total_credito_clp_uf' : total_credito_clp_uf,
                  'renta_sugerida': renta_sugerida,
                  'dividendo15': dividendo15,
                  'dividendo20': dividendo20,
                  'dividendo25': dividendo25,
                  'dividendo30': dividendo30},
                beforeSend: function(){
                    $('#loader').modal('show');
                },
                success: function (response) {
                   $('#loader').modal('hide');
                   $("#contenido").html(response);
                   $('html, body').animate({
                      scrollTop: $("#contenido").offset().top-70
                  }, 'slow');
                  return false;
                    }
          });
          }     
        );

        $( "#check_varsD" ).click(function() {
            
            var depto = $("#departamentoD").val();
            var est = $("#estacionamientoD").val();
            var bod = $("#bodegaD").val();
            var nombre_completo = $("#nombre_completoD").val();
            var rut = $("#rutD").val();
            var email = $("#emailD").val();
            var telefono = $("#telefonoD").val();
            var invertir_vivir = $("#invertir_vivirD").val();
           
            const validacionForm = validacion_cotizar(depto, nombre_completo, rut, email, telefono, invertir_vivir, 'D');
            if (!(validacionForm)) {
                return false;
            }

            var depto_values = depto.split("|");

            if(est.length > 1)
            {
                var est_values = est.split("|");

            }else{

                var est = "0|0|0| UF 0";
                var est_values = est.split("|");
            }
            
            if(bod.length > 1)
            {
                var bod_values = bod.split("|");

            }else{

                var bod = "0|0|0| UF 0";
                var bod_values = bod.split("|");

            }

         

            var values_depto = depto_values[4].split(" ");
            var values_est = est_values[3].split(" ");
            var values_bod = bod_values[3].split(" ");
          

            var total_propiedad_uf = parseFloat(values_depto[2]) + parseInt(values_est[2]) + parseInt(values_bod[2]);


            //datos cliente
            var proyecto = $("#proyecto").text();
            var url_imagen = $('#url_imgD').attr('src');

            var id_producto = {
                0 : values_depto[2]+"|"+depto_values[0],
                1 : values_est[2]+"|"+est_values[0],
                2 : values_bod[2]+"|"+bod_values[0],   
            };

            var total_propiedad = parseInt(total_propiedad_uf * uf_d);
            var total_propiedad_uf = total_propiedad_uf;
            console.log(total_propiedad);
            var montoFormat = total_propiedad.toString().replace(/[$.]/g,'');
            var parsePropiedad = parseInt(montoFormat);
            var porcentaje_pie = 15;
            var pie = (parsePropiedad*porcentaje_pie)/100;
            var pie_uf = pie/uf_d;
            var years = 25
            var cuotas = years*12;
            var tasa_interes = 5.6
            var total_credito_uf = total_propiedad_uf - pie_uf;
            var total_credito_clp = total_credito_uf*uf_d;
            var interes_mensual = (tasa_interes/100) /12;
            var dividendo = total_credito_uf/(((1-(1 + interes_mensual) ** - cuotas ))/interes_mensual);
            var dividendo15 = (total_credito_uf/(((1-(1 + interes_mensual) ** -  180))/interes_mensual))*uf_d;
            var dividendo20 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 240 ))/interes_mensual))*uf_d;
            var dividendo25 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 300 ))/interes_mensual))*uf_d;
            var dividendo30 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 360 ))/interes_mensual))*uf_d;
            var total_credito_clp_uf = dividendo * uf_d;
            var renta_sugerida = total_credito_clp_uf * 3.8;
            
              $.ajax({
                url: '../checkout.php',
                type: 'POST',
                data: {
                  'url_imagen': url_imagen,
                  'proyecto' : "42LINARES",
                  'nombre_completo' : nombre_completo,
                  'rut': rut,
                  'email': email,
                  'telefono' : telefono,
                  'invertir_vivir' : invertir_vivir,
                  'id_producto': id_producto,
                  'depto': depto,
                  'est' : est,
                  'bod' : bod,
                  'total_propiedad_uf' : total_propiedad_uf,
                  'total_propiedad_clp' : montoFormat, 
                  'porcentaje_pie': porcentaje_pie, 
                  'pie_clp': pie.toFixed(0), 
                  'pie_uf': pie_uf.toFixed(0),
                  'cuotas': cuotas.toFixed(0), 
                  'years': years, 
                  'tasa_interes': tasa_interes,
                  'uf_dia': <?php echo $uf_actual?>,
                  'total_credito_uf': total_credito_uf,
                  'total_credito_clp': total_credito_clp,
                  'dividendo' : dividendo,
                  'total_credito_clp_uf' : total_credito_clp_uf,
                  'renta_sugerida': renta_sugerida,
                  'dividendo15': dividendo15,
                  'dividendo20': dividendo20,
                  'dividendo25': dividendo25,
                  'dividendo30': dividendo30},
                beforeSend: function(){
                    $('#loader').modal('show');
                },
                success: function (response) {
                   $('#loader').modal('hide');
                   $("#contenido").html(response);
                   $('html, body').animate({
                      scrollTop: $("#contenido").offset().top-70
                  }, 'slow');
                  return false;
                    }
          });
          }     
        );

        $( "#check_varsB" ).click(function() {
            
            var depto = $("#departamentoB").val();
            var est = $("#estacionamientoB").val();
            var bod = $("#bodegaB").val();
            var nombre_completo = $("#nombre_completoB").val();
            var rut = $("#rutB").val();
            var email = $("#emailB").val();
            var telefono = $("#telefonoB").val();
            var invertir_vivir = $("#invertir_vivirB").val();

            const validacionForm = validacion_cotizar(depto, nombre_completo, rut, email, telefono, invertir_vivir, 'B');
            if (!(validacionForm)) {
                return false;
            }
            var depto_values = depto.split("|");

            if(est.length > 1)
            {
                var est_values = est.split("|");

            }else{

                var est = "0|0|0| UF 0";
                var est_values = est.split("|");
            }
            
            if(bod.length > 1)
            {
                var bod_values = bod.split("|");

            }else{

                var bod = "0|0|0| UF 0";
                var bod_values = bod.split("|");

            }


            var values_depto = depto_values[4].split(" ");
            var values_est = est_values[3].split(" ");
            var values_bod = bod_values[3].split(" ");


            var total_propiedad_uf = parseFloat(values_depto[2]) + parseInt(values_est[2]) + parseInt(values_bod[2]);


            //datos cliente
            var proyecto = $("#proyecto").text();
            

            var url_imagen = $('#url_imgB').attr('src');

            var id_producto = {
                0 : values_depto[2]+"|"+depto_values[0],
                1 : values_est[2]+"|"+est_values[0],
                2 : values_bod[2]+"|"+bod_values[0],   
            };
            var total_propiedad = parseInt(total_propiedad_uf * uf_d);
            var total_propiedad_uf = total_propiedad_uf;
            
            var montoFormat = total_propiedad.toString().replace(/[$.]/g,'');
            var parsePropiedad = parseInt(montoFormat);
            var porcentaje_pie = 15;
            var pie = (parsePropiedad*porcentaje_pie)/100;
            var pie_uf = pie/uf_d;
            var years = 25
            var cuotas = years*12;
            var tasa_interes = 5.6
            var total_credito_uf = total_propiedad_uf - pie_uf;
            var total_credito_clp = total_credito_uf*uf_d;
            var interes_mensual = (tasa_interes/100) /12;
            var dividendo = total_credito_uf/(((1-(1 + interes_mensual) ** - cuotas ))/interes_mensual);
            var dividendo15 = (total_credito_uf/(((1-(1 + interes_mensual) ** -  180))/interes_mensual))*uf_d;
            var dividendo20 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 240 ))/interes_mensual))*uf_d;
            var dividendo25 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 300 ))/interes_mensual))*uf_d;
            var dividendo30 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 360 ))/interes_mensual))*uf_d;
            var total_credito_clp_uf = dividendo * uf_d;
            var renta_sugerida = total_credito_clp_uf * 3.8;
            
              $.ajax({
                url: '../checkout.php',
                type: 'POST',
                data: {
                  'url_imagen': url_imagen,
                  'proyecto' : "42LINARES",
                  'nombre_completo' : nombre_completo,
                  'rut': rut,
                  'email': email,
                  'telefono' : telefono,
                  'invertir_vivir' : invertir_vivir,
                  'id_producto': id_producto,
                  'depto': depto,
                  'est' : est,
                  'bod' : bod,
                  'total_propiedad_uf' : total_propiedad_uf,
                  'total_propiedad_clp' : montoFormat, 
                  'porcentaje_pie': porcentaje_pie, 
                  'pie_clp': pie.toFixed(0), 
                  'pie_uf': pie_uf.toFixed(0),
                  'cuotas': cuotas.toFixed(0), 
                  'years': years, 
                  'tasa_interes': tasa_interes,
                  'uf_dia': <?php echo $uf_actual?>,
                  'total_credito_uf': total_credito_uf,
                  'total_credito_clp': total_credito_clp,
                  'dividendo' : dividendo,
                  'total_credito_clp_uf' : total_credito_clp_uf,
                  'renta_sugerida': renta_sugerida,
                  'dividendo15': dividendo15,
                  'dividendo20': dividendo20,
                  'dividendo25': dividendo25,
                  'dividendo30': dividendo30},
                beforeSend: function(){
                    $('#loader').modal('show');
                },
                success: function (response) {
                   $('#loader').modal('hide');
                   $("#contenido").html(response);
                   $('html, body').animate({
                      scrollTop: $("#contenido").offset().top-70
                  }, 'slow');
                  return false;
                    }
          });
          }     
        );

        $( "#check_varsA3" ).click(function() {
            
            var depto = $("#departamentoA3").val();
            var est = $("#estacionamientoA3").val();
            var bod = $("#bodegaA3").val();
            var nombre_completo = $("#nombre_completoA3").val();
            var rut = $("#rutA3").val();
            var email = $("#emailA3").val();
            var telefono = $("#telefonoA3").val();
            var invertir_vivir = $("#invertir_vivirA3").val();

            const validacionForm = validacion_cotizar(depto, nombre_completo, rut, email, telefono, invertir_vivir, 'A3');
            if (!(validacionForm)) {
                return false;
            }
            var depto_values = depto.split("|");

            if(est.length > 1)
            {
                var est_values = est.split("|");

            }else{

                var est = "0|0|0| UF 0";
                var est_values = est.split("|");
            }
            
            if(bod.length > 1)
            {
                var bod_values = bod.split("|");

            }else{

                var bod = "0|0|0| UF 0";
                var bod_values = bod.split("|");

            }

        

            var values_depto = depto_values[4].split(" ");
            var values_est = est_values[3].split(" ");
            var values_bod = bod_values[3].split(" ");

            var total_propiedad_uf = parseFloat(values_depto[2]) + parseInt(values_est[2]) + parseInt(values_bod[2]);


            //datos cliente
            var proyecto = $("#proyectoA3").text();
            

            var url_imagen = $('#url_imgA3').attr('src');

            var id_producto = {
                0 : values_depto[2]+"|"+depto_values[0],
                1 : values_est[2]+"|"+est_values[0],
                2 : values_bod[2]+"|"+bod_values[0],   
            };
            var total_propiedad = parseInt(total_propiedad_uf * uf_d);
            var total_propiedad_uf = total_propiedad_uf;
           
            var montoFormat = total_propiedad.toString().replace(/[$.]/g,'');
            var parsePropiedad = parseInt(montoFormat);
            var porcentaje_pie = 15;
            var pie = (parsePropiedad*porcentaje_pie)/100;
            var pie_uf = pie/uf_d;
            var years = 25
            var cuotas = years*12;
            var tasa_interes = 5.6
            var total_credito_uf = total_propiedad_uf - pie_uf;
            var total_credito_clp = total_credito_uf*uf_d;
            var interes_mensual = (tasa_interes/100) /12;
            var dividendo = total_credito_uf/(((1-(1 + interes_mensual) ** - cuotas ))/interes_mensual);
            var dividendo15 = (total_credito_uf/(((1-(1 + interes_mensual) ** -  180))/interes_mensual))*uf_d;
            var dividendo20 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 240 ))/interes_mensual))*uf_d;
            var dividendo25 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 300 ))/interes_mensual))*uf_d;
            var dividendo30 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 360 ))/interes_mensual))*uf_d;
            var total_credito_clp_uf = dividendo * uf_d;
            var renta_sugerida = total_credito_clp_uf * 3.8;
            
              $.ajax({
                url: '../checkout.php',
                type: 'POST',
                data: {
                  'url_imagen': url_imagen,
                  'proyecto' : "42LINARES",
                  'nombre_completo' : nombre_completo,
                  'rut': rut,
                  'email': email,
                  'telefono' : telefono,
                  'invertir_vivir' : invertir_vivir,
                  'id_producto': id_producto,
                  'depto': depto,
                  'est' : est,
                  'bod' : bod,
                  'total_propiedad_uf' : total_propiedad_uf,
                  'total_propiedad_clp' : montoFormat, 
                  'porcentaje_pie': porcentaje_pie, 
                  'pie_clp': pie.toFixed(0), 
                  'pie_uf': pie_uf.toFixed(0),
                  'cuotas': cuotas.toFixed(0), 
                  'years': years, 
                  'tasa_interes': tasa_interes,
                  'uf_dia': <?php echo $uf_actual?>,
                  'total_credito_uf': total_credito_uf,
                  'total_credito_clp': total_credito_clp,
                  'dividendo' : dividendo,
                  'total_credito_clp_uf' : total_credito_clp_uf,
                  'renta_sugerida': renta_sugerida,
                  'dividendo15': dividendo15,
                  'dividendo20': dividendo20,
                  'dividendo25': dividendo25,
                  'dividendo30': dividendo30},
                beforeSend: function(){
                    $('#loader').modal('show');
                },
                success: function (response) {
                   $('#loader').modal('hide');
                   $("#contenido").html(response);
                   $('html, body').animate({
                      scrollTop: $("#contenido").offset().top-70
                  }, 'slow');
                  return false;
                    }
          });
          }     
        );

        $( "#check_varsA4" ).click(function() {
            
            var depto = $("#departamentoA4").val();
            var est = $("#estacionamientoA4").val();
            var bod = $("#bodegaA4").val();
            var nombre_completo = $("#nombre_completoA4").val();
            var rut = $("#rutA4").val();
            var email = $("#emailA4").val();
            var telefono = $("#telefonoA4").val();
            var invertir_vivir = $("#invertir_vivirA4").val();

            const validacionForm = validacion_cotizar(depto, nombre_completo, rut, email, telefono, invertir_vivir, 'A4');
            if (!(validacionForm)) {
                return false;
            }
     
            var depto_values = depto.split("|");

            if(est.length > 1)
            {
                var est_values = est.split("|");

            }else{

                var est = "0|0|0| UF 0";
                var est_values = est.split("|");
            }
            
            if(bod.length > 1)
            {
                var bod_values = bod.split("|");

            }else{

                var bod = "0|0|0| UF 0";
                var bod_values = bod.split("|");

            }

           
      

            var values_depto = depto_values[4].split(" ");
            var values_est = est_values[3].split(" ");
            var values_bod = bod_values[3].split(" ");
        

            var total_propiedad_uf = parseFloat(values_depto[2]) + parseInt(values_est[2]) + parseInt(values_bod[2]);

         

            //datos cliente
            var proyecto = $("#proyecto").text();
            

            var url_imagen = $('#url_imgA4').attr('src');

            var id_producto = {
                0 : values_depto[2]+"|"+depto_values[0],
                1 : values_est[2]+"|"+est_values[0],
                2 : values_bod[2]+"|"+bod_values[0],   
            };
            var total_propiedad = parseInt(total_propiedad_uf * uf_d);
            var total_propiedad_uf = total_propiedad_uf;
            
            var montoFormat = total_propiedad.toString().replace(/[$.]/g,'');
            var parsePropiedad = parseInt(montoFormat);
            var porcentaje_pie = 15;
            var pie = (parsePropiedad*porcentaje_pie)/100;
            var pie_uf = pie/uf_d;
            var years = 25
            var cuotas = years*12;
            var tasa_interes = 5.6
            var total_credito_uf = total_propiedad_uf - pie_uf;
            var total_credito_clp = total_credito_uf*uf_d;
            var interes_mensual = (tasa_interes/100) /12;
            var dividendo = total_credito_uf/(((1-(1 + interes_mensual) ** - cuotas ))/interes_mensual);
            var dividendo15 = (total_credito_uf/(((1-(1 + interes_mensual) ** -  180))/interes_mensual))*uf_d;
            var dividendo20 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 240 ))/interes_mensual))*uf_d;
            var dividendo25 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 300 ))/interes_mensual))*uf_d;
            var dividendo30 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 360 ))/interes_mensual))*uf_d;
            var total_credito_clp_uf = dividendo * uf_d;
            var renta_sugerida = total_credito_clp_uf * 3.8;
            
              $.ajax({
                url: '../checkout.php',
                type: 'POST',
                data: {
                  'url_imagen': url_imagen,
                  'proyecto' : "42LINARES",
                  'nombre_completo' : nombre_completo,
                  'rut': rut,
                  'email': email,
                  'telefono' : telefono,
                  'invertir_vivir' : invertir_vivir,
                  'id_producto': id_producto,
                  'depto': depto,
                  'est' : est,
                  'bod' : bod,
                  'total_propiedad_uf' : total_propiedad_uf,
                  'total_propiedad_clp' : montoFormat, 
                  'porcentaje_pie': porcentaje_pie, 
                  'pie_clp': pie.toFixed(0), 
                  'pie_uf': pie_uf.toFixed(0),
                  'cuotas': cuotas.toFixed(0), 
                  'years': years, 
                  'tasa_interes': tasa_interes,
                  'uf_dia': <?php echo $uf_actual?>,
                  'total_credito_uf': total_credito_uf,
                  'total_credito_clp': total_credito_clp,
                  'dividendo' : dividendo,
                  'total_credito_clp_uf' : total_credito_clp_uf,
                  'renta_sugerida': renta_sugerida,
                  'dividendo15': dividendo15,
                  'dividendo20': dividendo20,
                  'dividendo25': dividendo25,
                  'dividendo30': dividendo30},
                beforeSend: function(){
                    $('#loader').modal('show');
                },
                success: function (response) {
                   $('#loader').modal('hide');
                   $("#contenido").html(response);
                   $('html, body').animate({
                      scrollTop: $("#contenido").offset().top-70
                  }, 'slow');
                  return false;
                    }
          });
          }     
        );

        $( "#check_varsC3" ).click(function() {
            
            var depto = $("#departamentoC3").val();
            var est = $("#estacionamientoC3").val();
            var bod = $("#bodegaC3").val();
            var nombre_completo = $("#nombre_completoC3").val();
            var rut = $("#rutC3").val();
            var email = $("#emailC3").val();
            var telefono = $("#telefonoC3").val();
            var invertir_vivir = $("#invertir_vivirC3").val();

            const validacionForm = validacion_cotizar(depto, nombre_completo, rut, email, telefono, invertir_vivir, 'C3');
            if (!(validacionForm)) {
                return false;
            }
            
            var depto_values = depto.split("|");

            if(est.length > 1)
            {
                var est_values = est.split("|");

            }else{

                var est = "0|0|0| UF 0";
                var est_values = est.split("|");
            }
            
            if(bod.length > 1)
            {
                var bod_values = bod.split("|");

            }else{

                var bod = "0|0|0| UF 0";
                var bod_values = bod.split("|");

            }


            var values_depto = depto_values[4].split(" ");
            var values_est = est_values[3].split(" ");
            var values_bod = bod_values[3].split(" ");
        
            var total_propiedad_uf = parseFloat(values_depto[2]) + parseInt(values_est[2]) + parseInt(values_bod[2]);



            //datos cliente
            var proyecto = $("#proyecto").text();
            

            var url_imagen = $('#url_imgC3').attr('src');

            var id_producto = {
                0 : values_depto[2]+"|"+depto_values[0],
                1 : values_est[2]+"|"+est_values[0],
                2 : values_bod[2]+"|"+bod_values[0],   
            };
            var total_propiedad = parseInt(total_propiedad_uf * uf_d);
            var total_propiedad_uf = total_propiedad_uf;
            
            var montoFormat = total_propiedad.toString().replace(/[$.]/g,'');
            var parsePropiedad = parseInt(montoFormat);
            var porcentaje_pie = 15;
            var pie = (parsePropiedad*porcentaje_pie)/100;
            var pie_uf = pie/uf_d;
            var years = 25
            var cuotas = years*12;
            var tasa_interes = 5.6
            var total_credito_uf = total_propiedad_uf - pie_uf;
            var total_credito_clp = total_credito_uf*uf_d;
            var interes_mensual = (tasa_interes/100) /12;
            var dividendo = total_credito_uf/(((1-(1 + interes_mensual) ** - cuotas ))/interes_mensual);
            var dividendo15 = (total_credito_uf/(((1-(1 + interes_mensual) ** -  180))/interes_mensual))*uf_d;
            var dividendo20 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 240 ))/interes_mensual))*uf_d;
            var dividendo25 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 300 ))/interes_mensual))*uf_d;
            var dividendo30 = (total_credito_uf/(((1-(1 + interes_mensual) ** - 360 ))/interes_mensual))*uf_d;
            var total_credito_clp_uf = dividendo * uf_d;
            var renta_sugerida = total_credito_clp_uf * 3.8;
            
              $.ajax({
                url: '../checkout.php',
                type: 'POST',
                data: {
                  'url_imagen' : url_imagen,
                  'proyecto' : "42LINARES",
                  'nombre_completo' : nombre_completo,
                  'rut': rut,
                  'email': email,
                  'telefono' : telefono,
                  'invertir_vivir' : invertir_vivir,
                  'id_producto': id_producto,
                  'depto': depto,
                  'est' : est,
                  'bod' : bod,
                  'total_propiedad_uf' : total_propiedad_uf,
                  'total_propiedad_clp' : montoFormat, 
                  'porcentaje_pie': porcentaje_pie, 
                  'pie_clp': pie.toFixed(0), 
                  'pie_uf': pie_uf.toFixed(0),
                  'cuotas': cuotas.toFixed(0), 
                  'years': years, 
                  'tasa_interes': tasa_interes,
                  'uf_dia': <?php echo $uf_actual?>,
                  'total_credito_uf': total_credito_uf,
                  'total_credito_clp': total_credito_clp,
                  'dividendo' : dividendo,
                  'total_credito_clp_uf' : total_credito_clp_uf,
                  'renta_sugerida': renta_sugerida,
                  'dividendo15': dividendo15,
                  'dividendo20': dividendo20,
                  'dividendo25': dividendo25,
                  'dividendo30': dividendo30},
                beforeSend: function(){
                    $('#loader').modal('show');
                },
                success: function (response) {
                   $('#loader').modal('hide');
                   $("#contenido").html(response);
                   $('html, body').animate({
                      scrollTop: $("#contenido").offset().top-70
                  }, 'slow');
                  return false;
                    }
          });
          }     
        );

//Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
function postLogin(){
    $('#irLogIn').attr('action', '../login.php');
    $('#irLogIn').submit();
}
</script>
</body>
</html>