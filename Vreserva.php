<?php

require_once 'includes/db.php';
require_once 'vendor/ti.php';
session_start();

$varsesion = $_SESSION['rut'];
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$llave = false;
if($enlace_actual == 'http://localhost/salaventas/Vreserva.php'){
    $llave = false;
}else{
    $llave = true;
}
if($varsesion == null || $varsesion = ''){
    if($llave == true)
    {
        header("Location: https://salaventas.surmonte.cl/login.php");
        die();
    }else{
        header("Location: https://localhost/salaventas/login.php");
    die();
    }

   
}
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
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
   <style>
      #a-home{
         color: #fff;
      }
      #a-reservas{
         color: rgb(255,151,53);
      }
   </style>
</head>
<header>
    <?php include 'includes/nav_admin.php';?>
</header>
<body style="background-color: white; font-family: Lato; margin-top: 100px;">
   <div class="container">
      <div class="row mt-4">
         <div class="col-12">
            <div class="card mb-4">
               
               <!-- <div class="container-fluid"> -->
                  <div class="card-body px-0 pt-0 pb-2">
                     <div class="row mx-5 mt-5">
                        <div class="col-12 col-md-6 justify-content-center justify-content-md-start">
                           <h3>Mis Reservas</h3>
                        </div>
                     </div>
                     <div class="table-responsive p-5">
                        <table id="reserv" class="table table-striped align-items-center mb-0 table-hover display table-bordered dt-responsive nowrap table-condensed" style="width:100%">
                           <thead>
                                 <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rut</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Proyecto</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado <i class="fa-regular fa-circle-question" data-bs-toggle="tooltip" data-bs-placement="top" title="Trámite: . Promesa: ."></i></th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cotización</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha reserva</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acción</th>
                                 </tr>
                           </thead>
                           <tbody>
                              
                           </tbody>
            
                        </table>
                     </div>
                  </div>
               <!-- </div> -->

            </div>
      </div>
   </div>
   <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="assets/js/sidebar.js"></script>

   <!-- solo chart -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
   <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script> -->
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
   <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
   <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
   <!-- <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script> -->
   <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>


   <script type="text/javascript">

   var mediaqueryList = window.matchMedia("(orientation: portrait)");

   $(document).ready(function () {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
      }); 
      $.ajax({
            url: "obtener_reg_res.php",
            data: {"rut": "<?php echo  $_SESSION['rut']; ?>"},
            type: "POST",
            serverside:true,
            dataType: "json",
            success: function(data){
               console.log(data);
               var table = $('#reserv').DataTable({
                  responsive: true,
                  fixedHeader: true,
                  fixedColumns: true,
                  data: data,
                  columns:[
                     {data: "id_reserva"},
                     {data: "rut_cli"},
                     {data: "proyecto"},
                     {data: "estado"},
                     {data: "id_cot"},
                     {data: "fec_res"},
                     {"defaultContent": "<div style='text-align: center'><button style='background-color: rgb(255 151 53); color: white;' type='button'  class='form btn btn-xs '>Ver Detalle</button></div>"}
                  ],language: {
                  "sProcessing":     "Procesando...",
                  "sLengthMenu":     "Registros",
                  "sZeroRecords":    "No se encontraron resultados",
                  "sEmptyTable":     "Ningún dato disponible en esta tabla",
                  "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros.",
                  // "sInfo":           "Mostrando registros del START al END de un total de TOTAL registros",
                  "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                  "sInfoFiltered":   "(filtrado de un total de MAX registros)",
                  "sInfoPostFix":    "",
                  // "sSearch":         "Buscar:",
                  "sUrl":            "",
                  "sInfoThousands":  ",",
                  "sLoadingRecords": "Cargando...",
                  "oPaginate": {
                     "sFirst":    "Primero",
                     "sLast":     "Último",
                     "sNext":     "Siguiente",
                     "sPrevious": "Anterior"
                  },
                  "oAria": {
                     "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                  }
               },
               columnDefs: [{
                  width: "20px",
                  targets: 0
                  },
                  {
                  width: "20px",
                  targets: 1
                  },
                  {
                  width: "20px",
                  targets: 2
                  },
                  {

                     width: "40px",
                     targets: 3
                     
                  }
               ]
            });
            // $('#reserv tbody').on( 'tr', function () {
            //    var data = table.row( this ).data();
            //    alert( 'Click en '+data.estado+'' );
            // } );


            if (screen.width < 1130){
               $('#coreservt tbody').on('click', 'button.form', function () //Al hacer click sobre el boton button.form de la linea de arriba
               {
                  var data_form = table.row($(this).parents("li")).data();
                  alert(data_form.id_reserva);
                  // alert(data_form);
                  console.log(data_form);
               } );
            }else {
               // alert("Grande") 
               
               $('#reserv tbody').on('click', 'button.form', function () //Al hacer click sobre el boton button.form de la linea de arriba
               {
                  var data_form = table.row($(this).parents("td")).data();
                  var dato = data_form.id_cot;

                  // alert("Detalle: "+dato);
                  // alert(data_form);
                  // alert(dato);
                  url = "detReserva.php?cot=" + dato
                  $(location).attr('href',url); 
               
         
               } );
            }         
               

         }
         
      });

      
   });
   </script>

       
</body>
</html>