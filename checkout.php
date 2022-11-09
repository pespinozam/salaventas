<?php

$id_producto = $_POST["id_producto"];

$departamento = $_POST["depto"];
$bodega = $_POST["bod"];
$estacionamiento = $_POST["est"];

$nombre_completo = $_POST["nombre_completo"];
$rut = $_POST["rut"];
$email = $_POST["email"];
$estacionamiento = $_POST["est"];
$telefono = $_POST["telefono"];
$invertir_vivir = $_POST["invertir_vivir"];
$proyecto = $_POST["proyecto"];
$url_imagen = $_POST["url_imagen"];




//Cliente post
$post1 = [
  "rutCliente" => str_replace(".","",$rut),
  "nombreCliente" => $nombre_completo,
  "email" => $email,
  "sexo" => "",
  "estadoCivil" => "",
  "profesion" => "",
  "cantHijos" => 0,
  "nivelEdu" => "",
  "telefono1" => $telefono,
  "telefono2" => "",
  "fNac" => null,
  "direccion" => "",
  "numero" => "",
  "ndpto" => "",
  "idCiudad" => 0,
  "idComuna" => 0,
  "idReg" => 0,
  "tipoCliente" => "",
  "cedula" => ""
];

$login = 'apisurmonte';
$password = 'API2021_smnt';

$id_proyecto = 0;

$ch = curl_init('https://api.surmonte.cl/v1/proyectos');
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// execute!
$response = curl_exec($ch);

$json_response = json_decode($response, true);

foreach($json_response["data"] as $val){
  if($val["proyecto_nombre"] == $proyecto)
    {
      $id_proyecto = $val["proyecto_id"];
    }
}
// close the connection, release resources used
curl_close($ch);

$ch = curl_init('https://api.surmonte.cl/v1/clientes');
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post1));

// execute!
$response = curl_exec($ch);

$json_response = json_decode($response, true);
// close the connection, release resources used
curl_close($ch);

$hoy = date("Y-m-d H:i:s");

$authorization_token = "c688517e5411dbfb40d035d129c968dd071b227f";
//Cliente post Pipedrive
$post2 = [
  "title" => $proyecto."-".$email."-".$telefono,
  "value" => $nombre_completo,
  "currency" =>"CLP",
  "user_id" => "",
  "person_id" => "",
  "org_id" => 5,
  "pipeline_id" => 16,
  "stage_id" => 96,
  "status" => "open",
  "expected_close_date" => "",
  "probability" => "",
  "lost_reason" => "",
  "visible_to" => "3",
  "add_time" => $hoy
];

$ch = curl_init('https://api.pipedrive.com/v1/deals?api_token='.$authorization_token);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post2));

$result = curl_exec($ch);
curl_close($ch);

$departamento_values = explode("|",$departamento);
$bodega_values = explode("|",$bodega);
$estacionamiento_values = explode("|",$estacionamiento);

$total_propiedad_uf = ($_POST["total_propiedad_uf"]/1.05);
$total_propiedad_clp = $_POST["total_propiedad_clp"];
$porcentaje_pie = $_POST["porcentaje_pie"];
$pie_clp = $_POST["pie_clp"];
$pie_uf = $_POST["pie_uf"];
$cuotas = $_POST["cuotas"];
$years = $_POST["years"];
$tasa_interes = $_POST["tasa_interes"];
$uf_dia = $_POST["uf_dia"];
$total_credito_uf = $_POST["total_credito_uf"];
$total_credito_clp = $_POST["total_credito_clp"];
$dividendo_final = $_POST["dividendo"];
$dividendo_clp = $_POST["total_credito_clp_uf"];
$renta_sugerida = $_POST["renta_sugerida"];

$dividendo15 = $_POST["dividendo15"];
$dividendo20 = $_POST["dividendo20"];
$dividendo25 = $_POST["dividendo25"];
$dividendo30 = $_POST["dividendo30"];

$login = 'apisurmonte';
$password = 'API2021_smnt';

//Cotizacion post
$post2 = [
  "idCliente" => str_replace(".","",$rut),
  "fecha" => $hoy,
  "medios" => 8,
  "soporte" => 8,
  "razonCot" => "Vivienda",
  "nivelInte" => "Vip",
  "estado" => "Abierto",
  "proyecto" => $proyecto,
  "valorTotal" => $total_propiedad_uf,
  "valorDescuentos" => 0,
  "valorVenta" => 0
];

$ch = curl_init('https://api.surmonte.cl/v1/cotizaciones/');
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post2));
// execute!
$response = curl_exec($ch);
$json_response = json_decode($response, true);
$id_cotizacion = $json_response["id"];
// close the connection, release resources used
curl_close($ch);

for ($i=0; $i < count($id_producto); $i++) { 
    
  $productos_split = explode("|", $id_producto[$i]);

    $post3 = [
      "idProducto" => $productos_split[1],
      "idProyecto" => $id_proyecto,
      "precio" => $productos_split[0],
      "precioD" => 5
    ];

    $ch = curl_init('https://api.surmonte.cl/v1/cotizaciones/'.$id_cotizacion.'/detalle');
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post3));
    curl_exec($ch);
    // close the connection, release resources used
    curl_close($ch);
  }
?>
<!doctype html>
  <html lang="es">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Cotizador - Invertir Paso 2</title>
      <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
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
<body>
<br>
<div class="container">
<div class="row">
     <div class="col-12 col-md-12">
     <div id="section2" >
      <div id="cotizador-container" class="container-fluid row align-items-center">
        <div id="cotizador-vivir" class="inner-container">
          <div class="resumen-inner">
            <h2 class="cotizador-vivir-titulo mb-4">Resultado de la <strong>Cotización</strong> N° <span id="id_cotizacion"> <?php echo trim($id_cotizacion);?></span></h2>
            <hr class="col-12 mt-4">
            <div class="row col-4 form-input-full m-0 mb-3">
              <p>Valor de la UF hoy: $<span id="valor-uf"><b><?php echo number_format($uf_dia,2,',','.'); ?></b></span></p>
              <p>Nombre: <span id="nombre_cliente"><?php echo $nombre_completo; ?></span></p>
              <p>Rut: <span id="rut"><?php echo $rut; ?></span></p>
              <p>Correo: <span id="email"><?php echo $email; ?></span></p>
              <p>Teléfono: <span id="telefono"><?php echo $telefono; ?></span></p>
            </div>
            <hr class="col-md-12">
            <br>
            <div class="row resumen-credito-renta m-0">
              <div class="col-md-6 form-input-first">
                <p data-bs-toggle="tooltip" title="Precio lista del departamento" class="resumen-endeudamiento"><span class="titulo-resumen">Valor de la propiedad UF: </span><b><span id="valor-inversion-uf" class="valor-prop-uf"><?php echo number_format($total_propiedad_uf,1,',','.'); ?></span></b></p>
                <p data-bs-toggle="tooltip" title="Valor CLP calculado a la UF del día" class="resumen-endeudamiento"><span class="titulo-resumen">Valor de la propiedad CLP: </span><span class="simbolo"><b>$</span><span id="valor-inversion-clp" class="valor-prop-clp"><?php echo number_format($total_propiedad_clp,1,',','.'); ?></span></b></p>
                <p data-bs-toggle="tooltip" title="Renta estimada para poder a optar a esta vivienda. Es posible complementar." class="resumen-endeudamiento"><span class="titulo-resumen">Renta Sugerida: </span><span class="simbolo"><b>$</span><span id="valor-renta-clp" class="valor-prop-clp"><?php echo number_format($renta_sugerida,1,',','.')?></span></b> <span class="CLP">CLP</span> <small>(Complementaria)</small></p>
                <p data-bs-toggle="tooltip" title="Esta tasa es solo referencial, depende de las condiciones que te entregue tu entidad bancaria." class="resumen-endeudamiento"><span class="titulo-resumen">Tasa de interés: </span><span id="valor-tasa" class="valor-prop-uf"><b><?php echo $tasa_interes; ?></span> <span class="CLP">%</b></span></p>
                <p data-bs-toggle="tooltip" title="Dividendo aproximado calculado a 25 años." class="resumen-endeudamiento"><span class="titulo-resumen">Dividendo: </span><span class="simbolo"><b>UF </span><span id="valor-dividendo-clp" class="valor-prop-clp"><?php echo number_format($dividendo_final,2,',','.');?></span></b> <span id="valor-dividendo-clp-2" class="CLP"> | $<?php echo number_format($dividendo_clp,1,',','.');?> CLP)</span></p>
                <p data-bs-toggle="tooltip" title="Años referenciales." class="resumen-endeudamiento"><span class="titulo-resumen">Años de Hipoteca: </span><span id="valor-plazo" class="valor-prop-uf"><b><?php echo $years; ?></b></span></p>
                <p data-bs-toggle="tooltip" title="Pie del 15% del valor total de la propiedad." class="resumen-endeudamiento"><span class="titulo-resumen">Pie 15%: </span><span class="CLP"><b>UF</span> <span id="valor-pie-uf" class="valor-prop-uf"><?php echo number_format($pie_uf,2,',','.'); ?></span></b> <span> | </span><span class="simbolo">$</span><span id="valor-pie-clp" class="valor-prop-clp"><?php echo number_format($pie_clp,1,',','.');?></span> <span class="CLP">CLP</span><span></span></p>
                <p data-bs-toggle="tooltip" title="Financiamiento del 85%." class="resumen-endeudamiento"><span class="titulo-resumen">Porcentaje a financiar: </span><span class="CLP"><b>85%</span></p>
                <p data-bs-toggle="tooltip" title="Monto total del credito que debera ser solicitado al banco." class="resumen-endeudamiento"><span class="titulo-resumen">Crédito: </span><span class="CLP"><b>UF</span>  <span id="valor-credito-uf" class="valor-prop-uf"><?php echo number_format($total_credito_uf,1,',','.'); ?></span></b> <span> | </span><span class="simbolo">$</span><span id="valor-credito-clp" class="valor-prop-clp"><?php echo number_format($total_credito_clp,1,',','.'); ?></span> <span class="CLP">CLP</span><span></span></p>
              </div>
              <div class="col-md-6 form-input-last">
                <img data-bs-toggle="tooltip" width="600" height="450" id="url_imagen" title="Plano del departamento seleccionado." src="<?php echo $url_imagen; ?>"></img>
              </div>
              <div class="col-md-6">
                <p class="capacidad-endeudamiento"><small>(*) Valores referenciales. No incluye seguros de <b>desgravamen, incendios y sismos</b>.</small></p>
                <p class="capacidad-endeudamiento"><small>(*) Se considera en los cálculos una tasa de interés del <b><?php echo $tasa_interes;?> % </b>(el porcentaje final aplicado al crédito hipotecario depende de cada banco)</small></p> 
              </div>
              <div class="row">
                <div class="col-md-6">
                  <form method="POST" action="../pdf_generator.php" target="_blank">

                      <input type="hidden" name="uf_dia" value="<?php echo number_format($uf_dia,2,',','.'); ?>">
                      <input type="hidden" name="nombre_cliente" value="<?php echo $nombre_completo; ?>">
                      <input type="hidden" name="rut" value="<?php echo $rut; ?>">
                      <input type="hidden" name="correo" value="<?php echo $email; ?>">
                      <input type="hidden" name="telefono" value="<?php echo $telefono; ?>">
                      <input type="hidden" name="id_cotizacion" value="<?php echo $id_cotizacion;?>">
                      <input type="hidden" name="valor_propiedad" value="<?php echo number_format($total_propiedad_uf,1,',','.'); ?>">
                      <input type="hidden" name="valor_clp" value="<?php echo number_format($total_propiedad_clp,1,',','.'); ?>">
                      <input type="hidden" name="renta_sugerida" value="<?php echo number_format($renta_sugerida,1,',','.')?>">
                      <input type="hidden" name="div_final_uf" value="<?php echo number_format($dividendo_final,1,',','.');?>">
                      <input type="hidden" name="div_final_clp" value="<?php echo number_format($dividendo_clp,1,',','.');?>">
                      <input type="hidden" name="valor_pie_uf" value="<?php echo number_format($pie_uf,1,',','.'); ?>">
                      <input type="hidden" name="valor_pie_clp" value="<?php echo number_format($pie_clp,0,',','.');?>">
                      <input type="hidden" name="valor_credito_uf" value="<?php echo number_format($total_credito_uf,1,',','.'); ?>">
                      <input type="hidden" name="valor_credito_clp" value="<?php echo number_format($total_credito_clp,1,',','.'); ?>">
                      <input type="hidden" name="url_imagen" value="<?php echo $url_imagen; ?>">
                      <input type="hidden" name="depto" value="<?php echo $departamento; ?>">
                      <input type="hidden" name="bod" value="<?php echo $bodega; ?>">
                      <input type="hidden" name="est" value="<?php echo $estacionamiento; ?>">

                    <button type="submit" class="btn btn-light check_vars">Descarga tu cotización</button>
                    <!-- <a href="../email.php" role="button" class="btn btn-light check_vars">Enviar mail </a> -->
                 </form>
                 <br>
                </div>
              </div>                                                                                                                                             
              
              </div>        
            
            <hr class="col-12 mt-4">
            
          </div>
          <div class="resumen-inner">
            <div class="tooltip-consejo" id="tooltip-rentabilidad-dividendos"></div>
            <h2 data-bs-toggle="tooltip" title="Tabla que entrega valores estimados, son solo referenciales." class="cotizador-vivir-titulo mb-4">Dividendos y <strong>Rentas</strong></h2>
            <hr class="col-12 mt-4">
            <div class="table-responsive">
              <table class="table" id="tabla-plusvalia">
                <thead>
                  <tr>
                    <th scope="col">Plazo</th>
                    <th scope="col">Dividendo</th>
                    <th scope="col">Renta mínima</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>15 años</td> 
                    <td>$<?php echo number_format($dividendo15,1,',','.'); ?></td>
                    <td>$<?php echo number_format($dividendo15*3.8,1,',','.'); ?></td>
                  </tr>
                  <tr>
                    <td>20 años</td>
                    <td>$<?php echo number_format($dividendo20,1,',','.'); ?></td>
                    <td>$<?php echo number_format($dividendo20*3.8,1,',','.'); ?></td>
                  </tr>
                  <tr>
                    <td>25 años</td>           
                    <td>$<?php echo number_format($dividendo25,1,',','.'); ?></td>
                    <td>$<?php echo number_format($dividendo25*3.8,1,',','.'); ?></td>
                  </tr>
                  <tr>
                    <td>30 años</td>
                    <td>$<?php echo number_format($dividendo30,1,',','.'); ?></td>
                    <td>$<?php echo number_format($dividendo30*3.8,1,',','.'); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>    
            </br>
            <hr>
            <h1>Resumen de tus Productos</h1>
            <hr class="col-12 mt-4">
            
            <?php
            $search_vp = strrpos($departamento_values[4], 'UF ');
            $depa_val = substr($departamento_values[4], $search_vp);
            $depa_val = str_replace(array("UF "), '', $depa_val);
            $depa_val = floatval($depa_val);
            $depa_val = number_format($depa_val, 1, ',', '.');

            $search_est = strrpos($estacionamiento_values[3], 'UF ');
            $est_val = substr($estacionamiento_values[3], $search_est);
            $est_val = str_replace(array("UF "), '', $est_val);
            $est_val = floatval($est_val);
            $est_val = number_format($est_val, 1, ',', '.');

            $search_bod = strrpos($bodega_values[3], 'UF ');
            $bod_val = substr($bodega_values[3], $search_bod);
            $bod_val = str_replace(array("UF "), '', $bod_val);
            $bod_val = floatval($bod_val);
            $bod_val = number_format($bod_val, 1, ',', '.');






            // echo $depa_val;
            // $conv_vpropiedad = floatval($conv_vpropiedad);
            ?>
            <div class="row">
              <div class="col-md-8 v-center d-grid gap-1 col-6 mx-auto">
                <div class="table-responsive">            
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Productos</th>
                            <th style="width: 110px">Precio</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="table-active"><?php echo "Departamento: ".$departamento_values[1]." <br> Tipologia: ".$departamento_values[2]." <br> Detalle: ".$departamento_values[3]." <br> Orientación: ".$departamento_values[5]." <br> Superficie total:".$departamento_values[6]." <small>m2</small>" ?></td>
                            <td><b><?php echo 'UF '.$depa_val?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo "Estacionamiento: ".$estacionamiento_values[1]." <br> Tipo: ".$estacionamiento_values[2] ?></td>
                            <td><b><?php echo 'UF '.$est_val?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo "Bodega: ".$bodega_values[1]." <br> Tipo: ".$bodega_values[2]?></td>
                            <td><b><?php echo 'UF '.$bod_val?></b></td>
                        </tr>
                        <tr>
                          <td><b>Descuento</b></td>
                          <td><b>5%</b></td>
                        </tr>
                        <tr>
                          <td><b>Total</b></td>
                          <td data-bs-toggle="tooltip" title="Valor total de los productos seleccionados."><strong> UF <?php echo number_format($total_propiedad_uf,1,',','.'); ?></strong></td>
                        </tr>
                        <tr>
                          <td><hr></td>
                          <td><hr></td>
                        </tr>
                        <tr>
                            <td data-bs-toggle="tooltip" title="Valor a pagar inmediatamente."><b>Valor de la reserva</b></td>
                            <td data-bs-toggle="tooltip" title="Valor a pagar inmediatamente."><strong class="" style="color: rgb(255 151 53);"><b>CLP 150.000</b></strong></td>
                        </tr>
                        </tbody>
                    </table>
                 </div>
              </div>

              <div class="col-md-8 v-center d-grid gap-1 col-6 mx-auto">
                <form action="../reserva.php" method="POST">
                  <h4 class="cotizador-vivir-titulo mb-4">¿Te gusto este departamento? <strong><i>¡Reserva!</i></strong></h4>
                      <input type="hidden" id="depto" name="depto" value="<?php echo $departamento; ?>">
                      <input type="hidden" id="bod" name="bod" value="<?php echo $bodega; ?>">
                      <input type="hidden" id="est" name="est" value="<?php echo $estacionamiento; ?>">
                      <input type="hidden" name="total_uf" value=" <?php echo $total_propiedad_uf; ?>">
                      <input type="hidden" name="proyecto" value=" <?php echo $proyecto; ?>">
                      <input type="hidden" name="nombre_completo" value="<?php echo $nombre_completo; ?>">
                      <input type="hidden" name="rut" value="<?php echo $rut; ?>">
                      <input type="hidden" name="correo" value="<?php echo $email;?>">
                      <input type="hidden" name="telefono" value="<?php echo $telefono;?>">
                      <input type="hidden" name="id_cotizacion" value="<?php echo $id_cotizacion ; ?>">           
                      
                      <div class="v-center d-grid gap-1 col-6 mx-auto">
                          <button id="reservar" class="btn btn-dark check_vars">Reservar</button>
                      </div>
                  
                      <!-- <button id="reservar" class="btn btn-light check_vars">Reservar</button> -->
                </form>
              </div>
            </div>
            <br>
          </div>
          </div>     
        </div>
      </div>
</div>
     </div>
  </div>
</div>


<script src="sweetalert2.all.min.js"></script>
<script>
          
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});


        var uf_dia = $("#valor-uf").text();
        //Datos cliente
        var id_cotizacion = $("#id_cotizacion").text();
        var nombre_completo = $("#nombre_cliente").text();
        var rut = $("#rut").text();
        var email = $("#email").text();
        var telefono = $("#telefono").text();

        var valor_propiedad = $("#valor-inversion-uf").text();
        var valor_clp = $("#valor-inversion-clp").text();
        var renta_sugerida = $("#valor-renta-clp").text();
        var div_final_uf = $("#valor-dividendo-clp").text();
        var div_final_clp = $("#valor-dividendo-clp-2").text();
        var valor_pie_uf = $("#valor-pie-uf").text();
        var valor_pie_clp = $("#valor-pie-clp").text();
        var valor_credito_uf = $("#valor-credito-uf").text();
        var valor_credito_clp = $("#valor-credito-clp").text();
     

        var url_imagen = $('#url_imagen').attr('src');
      
        var depto = $("#depto").val();
        // console.log('before pdf g depto'+depto)
        var bod = $("#bod").val();
        // console.log('before pdf g bod'+bod)
        var est = $("#est").val();
        // console.log('before pdf g est'+est)


$(document).ready(function(){
      setTimeout(function(){
                // console.log('3 segundos');
              
                $.ajax({
                        url: '../pdf_generator.php',
                        type: 'POST',
                        data: {
                          "nombre_cliente" : nombre_completo,
                          "rut" : rut,
                          "correo" : email,
                          "telefono" : telefono,
                          "valor_propiedad" : valor_propiedad,
                          "valor_clp" : valor_clp,
                          "renta_sugerida" : renta_sugerida,
                          "div_final_uf" : div_final_uf,
                          "div_final_clp" : div_final_clp,
                          "valor_pie_uf" :valor_pie_uf,
                          "valor_pie_clp": valor_pie_clp,
                          "valor_credito_uf" : valor_credito_uf,
                          "valor_credito_clp" : valor_credito_clp,
                          "url_imagen": url_imagen,
                          "depto" : depto,
                          "bod" : bod,
                          "est" : est,
                          "uf_dia" : uf_dia,
                          "id_cotizacion" : id_cotizacion
                        },
                      success: function(response) {
                        
                      $.ajax({
                        url: '../email_notificacion_cotizacion.php',
                        type: 'POST',
                        data: {
                          'id_cotizacion': id_cotizacion,
                          'nombre_completo' : nombre_completo,
                          'rut': rut,
                          'email': email,
                          'telefono' : telefono,
                        },
                        beforeSend: function(){
                            $('#loader').modal('show');
                        },
                        success: function (response) {
                            $('#loader').modal('hide');
                        $.ajax({
                            url: '../email.php',
                            type: 'POST',
                            data: {
                              'nombre_completo' : nombre_completo,
                              'rut': rut,
                              'email': email,
                              'telefono' : telefono,
                              },
                            beforeSend: function(){
                                $('#loader').modal('show');
                            },
                            success: function (response) {
                                $('#loader').modal('hide');
                                
                                if(response.status = "existe")
                                {
                                  Swal.fire({
                                  title: 'Credenciales',
                                  text: '¡Hola! Nuestros registros indican que ya tienes una cuenta para acceder a tu portal.',
                                  imageUrl: '../assets/surmonte-logo-1.png',
                                  imageWidth: 140,
                                  imageHeight: 30,
                                  imageAlt: 'Logo surmonte',
                                  width: '500px'
                                });
                              }
                            }
                      });
                        }
                  });
                  }
                });
              },3000);
              
              });
</script>

    </body>
  </html>