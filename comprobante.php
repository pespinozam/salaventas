<?php
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$fecha_hoy = date('Y-m-d h:m:s');

$datos = $_POST["result"];
// echo $datos;
$datos_split = explode("|", $datos);

$html = '<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Comprobante de pago</title>
  </head>
  <body style="font-family: Arial, Helvetica, sans-serif;">
    <br> 
    
    <div >
    <div id="cotizador-container" class="container-fluid row align-items-center">
      <div id="cotizador-vivir" class="inner-container">
        <img src="assets/surmonte-logo-1.png" width="200">
        <hr>
        <table style="width: 100%">
          <tr>
            <td><h5>'.$fecha_hoy.'</h5></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><h5>Orden '.$datos_split[2].'</h5></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
        </table>
        <hr>
        <center><h4>Comprobante de pago</h4></center>
        <table class="table" style="width: 100%; border: solid 1px">
        <thead class="thead dark">
            <tr>
            <th style="text-align: left;">Concepto</th>
            <th>Detalle</th>
            </tr>
        </thead>
       <tbody>
          <tr>
          <td>Monto pagado </td>
          <td><b>$'.$datos_split[0].'</b></td>
          </tr>
          <tr>
          <td>Código Autorización</td>
          <td>'.$datos_split[1].'</td>
          </tr>
          <tr>
            <td>Orden: </td>
            <td>'.$datos_split[2].'</td>
          </tr>
          <tr>
            <td>Cuotas: </td>
            <td>'.$datos_split[3].'</td>
          </tr>
          <tr>
            <td>Estado: </td>
            <td>'.$datos_split[4].'</td>
          </tr>
          <tr>
            <td>Aprobación: </td>
            <td>'.$datos_split[5].'</td>
          </tr>
         </tbody>
        </table>
        <br>
        <p>Nota: Comprobante de pago de la reserva. La información mostrada en este documento son datos entregados por la plataforma de integración de Transbank. Con este documento se indica que se ha efectuado un pago correctamente a la sociedad del proyecto reservado.</p>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output("Comprobante.pdf","D");

?>


