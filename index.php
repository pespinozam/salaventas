<?php
session_start();



?>
<!DOCTYPE html>
<html>
<head>
<title>Tienda Surmonte</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/sidebar.css">
</head>
<header>
    <?php include 'includes/nav_home.php';?>
</header>
<body style="background-color: white; font-family: Lato; margin-top: 100px;">
<?php 
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$llave = false;
if($enlace_actual == 'http://localhost/salaventas/' || 'http://localhost/salaventas/index.php' ){
    $llave = false;
}else{
    $llave = true;
}
?>
<!-- 
<nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
  <div class="container-fluid">
  <img class="navbar-brand" src="assets/Logo_surmonte_2.png" alt="Surmonte Logo" style="width:200px;"></img>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="background-color: #808080; "></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-light" role="button" href="http://localhost/flujocompra/login.php"><i class="fa-solid fa-user"></i> Iniciar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav> -->

<div class="container mb-3" style=" margin-top: 100px; border: 1px; border-color: #808080; border-style: solid;">
  <div class="row">
      <div class="col-12 p-4 d-flex justify-content-center bg-dark text-light">
        <h3>Providencia</h3>
      </div>
  </div>
  <div class="row p-4">
    <div class="col-12 col-md-4  ">
        <div class="card">
            <div class="card-body">
              <?php 
                  if($llave == true){
                      echo '<a href="https://salaventas.surmonte.cl/proyectos/24crisostomo.php"><img style="width: 100%;" src="assets/proyectos/24CRISOSTOMO.PNG"></a>';
                  }else{
                      echo '<a href="http://localhost/salaventas/proyectos/24crisostomo.php"><img style="width: 100%;" src="assets/proyectos/24CRISOSTOMO.PNG"></a>';
                  }
              ?>
              
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 ">
    <div class="card">
            <div class="card-body">
              <?php 
                  if($llave == true){
                      echo '<a href="https://salaventas.surmonte.cl/proyectos/42linares.php"><img style="width: 100%;"  src="assets/proyectos/42LINARES.PNG"></a>';
                  }else{
                      echo '<a href="http://localhost/salaventas/proyectos/42linares.php"><img style="width: 100%;" src="assets/proyectos/42LINARES.PNG"></a>';
                  }
              ?>
            
            </div>
        </div>
    </div>
  </div>
</div>


<div class="container my-3 my-md-5" style="border: 1px; border-color: #808080; border-style: solid;">
  <div class="row">
      <div class="col-12 p-4 d-flex justify-content-center bg-dark text-light">
        <h3>Ñuñoa</h3>
      </div>
  </div>
  <div class="row p-4">
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-body">
              <?php 
                  if($llave == true){
                      echo '<a href="https://salaventas.surmonte.cl/proyectos/252marathon.php"><img style="width: 100%;" src="assets/proyectos/252MARATHON.PNG"></a>';
                  }else{
                      echo '<a href="http://localhost/salaventas/proyectos/252marathon.php"><img style="width: 100%;" src="assets/proyectos/252MARATHON.PNG"></a>';
                  }
              ?>
              
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
    <div class="card">
            <div class="card-body">
              <?php 
                  if($llave == true){
                      echo '<a href="https://salaventas.surmonte.cl/proyectos/ecv103.php"><img style="width: 100%;" src="assets/proyectos/ECV103.PNG"></a>';
                  }else{
                      echo '<a href="http://localhost/salaventas/proyectos/ecv103.php"><img style="width: 100%;" src="assets/proyectos/ECV103.PNG"></a>';
                  }
              ?>
            
            </div>
    </div>
    </div>
    <div class="col-12 col-md-4">
    <div class="card">
            <div class="card-body">
              <?php 
                  if($llave == true){
                      echo '<a href="https://salaventas.surmonte.cl/proyectos/talaveras72.php"><img style="width: 100%;" src="assets/proyectos/TALAVERAS72.PNG"></a>';
                  }else{
                      echo '<a href="http://localhost/salaventas/proyectos/talaveras72.php"><img style="width: 100%;" src="assets/proyectos/TALAVERAS72.PNG"></a>';
                  }
              ?>
            
            </div>
    </div>
    </div>
  </div>

</div>
<div class="container my-3 my-md-5" style="border: 1px; border-color: #808080; border-style: solid;">
  <div class="row">
      <div class="col-12 p-4 d-flex justify-content-center bg-dark text-light">
        <h3>Santiago</h3>
      </div>
  </div>
  <div class="row p-4">
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-body">
              <?php 
                  if($llave == true){
                      echo '<a href="https://salaventas.surmonte.cl/proyectos/131wood.php"><img  style="width: 100%;" src="assets/proyectos/131WOOD.PNG"></a>';
                  }else{
                      echo '<a href="http://localhost/salaventas/proyectos/131wood.php"><img style="width: 100%;" src="assets/proyectos/131WOOD.PNG"></a>';
                  }
              ?>
            
            </div>
        </div>
    </div>
  </div>

</div>
<div class="container my-3 my-md-5" style="border: 1px; border-color: #808080; border-style: solid;">
  <div class="row">
      <div class="col-12 p-4 d-flex justify-content-center bg-dark text-light">
        <h3>Independencia</h3>
      </div>
  </div>
  <div class="row p-4">
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-body">
              <?php 
                  if($llave == true){
                      echo '<a href="https://salaventas.surmonte.cl/proyectos/153sancristobal.php"><img style="width: 100%;" src="assets/proyectos/153SANCRISTOBAL.PNG"></a>';
                  }else{
                      echo '<a href="http://localhost/salaventas/proyectos/153sancristobal.php"><img style="width: 100%;" src="assets/proyectos/153SANCRISTOBAL.PNG"></a>';
                  }
              ?>
              
            </div>
        </div>
    </div>
  </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://kit.fontawesome.com/f5939545a8.js" crossorigin="anonymous"></script>
<script src="assets/js/sidebar.js"></script> 
<script>
  function postLogin(){
    $('#irLogIn').attr('action', 'login.php');
    $('#irLogIn').submit();
  }
</script>
</body>
</html>