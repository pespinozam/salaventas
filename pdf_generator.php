<?php
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$fecha_hoy = date('Y-m-d h:m:s');

$uf_dia = $_POST["uf_dia"];
// $uf_dia = number_format($uf_dia, 2, ',', '.');

$nombre = $_POST["nombre_cliente"];
$rut = $_POST["rut"]; 
$correo = $_POST["correo"]; 
$telefono = $_POST["telefono"]; 

$id_cotizacion = $_POST["id_cotizacion"];

$valor_propiedad = $_POST["valor_propiedad"];


$valor_clp = $_POST["valor_clp"]; 
$renta_sugerida = $_POST["renta_sugerida"]; 

$div_final_uf = $_POST["div_final_uf"]; 
$div_final_clp = $_POST["div_final_clp"];

$valor_pie_uf = $_POST["valor_pie_uf"]; 
$valor_pie_clp = $_POST["valor_pie_clp"];

$valor_credito_uf = $_POST["valor_credito_uf"] ;

$valor_credito_clp = $_POST["valor_credito_clp"];

$url_imagen = $_POST["url_imagen"];
$departamento = $_POST["depto"]; 
$bodega = $_POST["bod"];
$estacionamiento = $_POST["est"];

$departamento_values = explode("|",$departamento);
$bodega_values = explode("|",$bodega);
$estacionamiento_values = explode("|",$estacionamiento);


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


$html = '<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cotización Surmonte</title>
  </head>
  <body style="font-family: Arial, Helvetica, sans-serif;">
    <br> 
    <div id="section2" >
    <div id="cotizador-container" class="container-fluid row align-items-center">
      <div id="cotizador-vivir" class="inner-container">
        <img src="assets/surmonte-logo-1.png" width="200">
        <hr>
        <table style="width: 100%">
          <tr>
            <td><h5>'.$fecha_hoy.'</h5></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><h5>Cotización N° '.$id_cotizacion.'</h5></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><h5>Valor UF: $'.$uf_dia.'</h5></td>
          </tr>
        </table>
        <hr>
        <center><h4>Información cliente</h4></center>
        <table style="width: 100%" cellspacing="2" cellpadding="2">
        <tr>
          <td><h5>Nombre: '.$nombre.'</h5></td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td><h5>Rut:'. $rut.'</h5></td>
        </tr>
        <tr>
          <td><h5>E-mail: '.$correo.'</h5></td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td><h5>Teléfono: '.$telefono.'</h5></td>
        </tr>
        </table>
        <hr>
        <h4>Simulación de tu financiamiento</h4>
        <table style="width: 100%; text-aling: center;">
          <tr align="center">
            <td> <h5> Valor de la propiedad: UF '.$valor_propiedad .'</h5></td>
            <td style="text-aling: center;"> <h5> Valor de la propiedad CLP: $'. $valor_clp .'</h5></td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td> <h5> Renta sugerida : $'.$renta_sugerida .' (Complementaria)</h5></td>
            <td> <h5> Tasa de interes: %5.6 (*)<small>1</small></h5></td>
          </tr>
          <tr align="center">
          <td> <h5> Dividendo: UF '.$div_final_uf.' | $'.$div_final_clp.'</h5></td>
          <td> <h5> Años de Hipoteca: 25 </h5></td>
        </tr>
        <tr>
          <td> <h5> Pie: UF '.$valor_pie_uf .' | $'.$valor_pie_clp.'</h5></td>
          <td> <h5> Crédito Hipotecario: UF '.$valor_credito_uf.' | $'.$valor_credito_clp.' (*)<small>2</small></h5></td>
        </tr>
        </table>
        <hr>
        <h4>Detalle de productos seleccionados</h4>
        <p></p>
        <table style="width: 100%; text-align: justify;">
            <tr>
              <td><b>Productos</b></td>
              <td><b>Precios</b></td>
            </tr>
            <tr>
            <td><hr></td>
            <td><hr></td>
          </tr>
          <tbody>
            <tr>
              <td class="table-active"> Departamento:'. $departamento_values[1].'<br> Tipologia: '.$departamento_values[2].'<br> Detalle: '.$departamento_values[3].' <br> Orientación: '.$departamento_values[5].'<br> Superficie: '.$departamento_values[6].'</td>
              <td><b>'.$depa_val.'</b></td>
            </tr>
            <tr>
              <td>Estacionamiento: '.$estacionamiento_values[1].'<br> Tipo: '.$estacionamiento_values[2].'</td>
              <td><b>'.$est_val.'</b></td>
            </tr>
            <tr>
              <td>Bodega: '.$bodega_values[1].' <br> Tipo: '.$bodega_values[2].'</td>
              <td><b>'.$bod_val.'</b></td>
            </tr>
            <tr>
              <td class="table-active"> <b>Descuento</b></td>
              <td><b>5%</b></td>
            </tr>
           <tr>
            <tr>
              <td><b>Total</b></td>
              <td><strong> UF '.  $valor_propiedad .'</strong></td>
            </tr>
            <tr>
              <td><hr></td>
              <td><hr></td>
            </tr>
            <tr>
              <td ><b>Reserva ahora</b></td>
              <td ><strong><b>CLP 150.000</b></strong></td>
            </tr>
            </tbody>
            </table>
            <hr>
        <p><small>1 (*) Valores referenciales. No incluye seguros de desgravamen, incendios y sismos.</small></p>
        <p><small>2 (*) Se considera en los cálculos una tasa de interés del 5.6% (el porcentaje final aplicado al crédito hipotecario depende de cada banco)</small></p> 
        <p><small>Para disminuir el plazo de pago en tu crédito hipotecario puedes <b>complementar renta</b> con tu pareja, conyúge, hijo o familiar directo.</small></p>
            <img src="assets/surmonte-logo-1.png" width="200">
            <hr>
            <h4>Planta: '.$departamento_values[2].'</h4>
            <img  width="800" height="600"  src="'. $url_imagen.'"></img>    
</html>';


$mpdf->WriteHTML($html);
$mpdf->Output();
$mpdf->Output('cotizaciones_clientes/'.$rut."-".trim($id_cotizacion).".pdf", 'F');

?>


