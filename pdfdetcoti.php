<?php
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$fecha_hoy = date('Y-m-d h:m:s');

$uf_dia = $_POST["uf_dia"];
$coti = $_POST["coti"];
$nombre = $_POST["nom_cli"];
$rut = $_POST["rut_cli"]; 
$correo = $_POST["email"]; 
$telefono = $_POST["fono"];

$proy = $_POST["proy"];
$deptop = $_POST["deptop"];
$tipolog = $_POST["tipolog"];
$program = $_POST["program"];
$orienta = $_POST["orienta"];
$suptol = $_POST["suptol"];
$ubiEst = $_POST["ubiEst"];
$cantEst = $_POST["cantEst"];
$cantBod = $_POST["cantBod"];

$valor_propiedad = $_POST["priceTal"]; // valor en uf
$vp_clp = $_POST["clptotal"];  // valor propiedad en clp

$uf_dia = number_format($uf_dia, 2, ',', '.');



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
            <td><h5>Cotización N° '.$coti.'</h5></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><h5>UF '.$uf_dia.'</h5></td>
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
            <td style="text-aling: center;"> <h5> Valor de la propiedad CLP: $'. $vp_clp .'</h5></td>
          </tr>
          <tr>
          </tr>
        </table>
        <hr>
        <h4>¡Este es el detalle de tus productos seleccionados!</h4>
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
              <td class="table-active"><b>Proyecto:   </b>'. $proy .'<br> <b>Departamento:   </b>'. $deptop.'<br> <b>Tipologia:   </b>'.$tipolog.'<br> <b>Detalle:   </b>'.$program.' <br> <b>Orientación:   </b>'.$orienta.'<br> <b>Superficie:   </b>'.$suptol.'</td>
              
            </tr>
            <tr>
              <td><b>Ubicación Estacionamiento:</b>   '.$ubiEst.'<br><b> Cantidad estacionamiento:</b>   '.$cantEst.'</td>
              
            </tr>
            <tr>
              <td><b>Cantidad de bodega(s): </b>'.$cantBod.'</td>
              
            </tr>
            <tr>
              <td class="table-active"> <b>Descuento</b></td>
              <td><b>5%</b></td>
            </tr>
           <tr>
            <tr>
              <td><b>Total</b></td>
              <td><strong> UF '.  $valor_propiedad .'</strong></td>
              <td><strong> CLP '.  $vp_clp .'</strong></td>
            </tr>
            <tr>
              <td><hr></td>
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
             
</html>';


$mpdf->WriteHTML($html);
$mpdf->Output();
$mpdf->Output('cotizaciones_clientes/'.$rut."-".trim($coti).".pdf", 'F');

?>

<script type="text/javascript">
  
 
  
</script>
