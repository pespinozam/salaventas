<?php 
session_start();

$usuario = isset($_POST["usuario"]) ? $_POST["usuario"]: null;
$url = isset($_POST["url"]) ? $_POST["url"]: null;

$link_capturado = $_POST['linkred'];
$search_vp = strrpos($link_capturado, '/f');
$link_capturado = substr($link_capturado, $search_vp);
// $conv_vpropiedad = str_replace(array("."), '', $conv_vpropiedad);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #212529;">
    <div class="container-fluid">
    <img class="navbar-brand" src="assets/Logo_surmonte_2.png" alt="Surmonte Logo" style="width:200px;"></img>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" style="background-color: #808080; "></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-light" role="button" href="index.php"><i class="fa-solid fa-user"></i>Inicio</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center" id="template-bg-3">

        <div class="card mb-5 px-5 py-3 text-white col-md-4" style="background-color: #212529;">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-center">
                        <h4>Iniciar Sesión</h4>
                    </div>

                </div>
                <form name="login" action="" method="post">
                    <div class="input-group form-group mt-3">
                        <input type="text" maxlength="12" data-bs-toggle="tooltip" class="form-control text-center p-3 rut" placeholder="Ingrese su rut" id="rut" name="usuario">
                        <!-- <input maxlength="12" data-bs-toggle="tooltip" title="Por favor escribe tu Rut" id="rutB2" class="form-control rut" name="nombre_proyecto"> -->
                    </div>
                    <div class="input-group form-group mt-3">
                        <input type="password" class="form-control text-center p-3" placeholder="Ingrese su contraseña" id="pass" name="contraseña">
                    </div>
                    <div class="text-center">
                        <input type="hidden" value="<?php echo $url; ?>" id="url">
                        <input id="btnAcceder" type="button" value="Acceder" class="btn btn-primary mt-3 w-100 p-2" name="login-btn">
                    </div>
                    <div id="respuesta"></div>
                </form>


                <?php if(!empty($loginResult)){?>
                <div class="text-danger"><?php echo $loginResult;?></div>
                <?php }?>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/jquery.rut.js"></script>


    <script type="text/javascript">

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        }); 


        $(".rut")
        .rut({formatOn: 'keyup', validateOn: 'keyup'})
        .on('rutInvalido', function(){ 
            $(".rut").css("border-color", "red");
            $(".rut").css("border-style", "solid");
        })
        .on('rutValido', function(){ 
            
            $(".rut").css("border-color", "green");
            $(".rut").css("border-style", "solid");
        });
        
        $('#btnAcceder').on('click', function(){
            const rut = $('#rut').val();
            const pass = $('#pass').val();
            const url = $('#url').val();

            if(url == null || url == '')
            {
                $.ajax({
                type: "post",
                url: "loginProceso.php",
                data: {"usuario": rut, "contraseña": pass},
                success: function (response) {
                    var datos = JSON.parse(response);
                    if(datos.estado == "error"){
                        $('#respuesta').append(`<br><div class="alert alert-danger" role="alert">
                            Error de autenticación!
                        </div>`);
                    }else if(datos.estado == "exito"){
                        

                        window.location.href = '<?php echo $link_capturado ?>';
                        // console.log(link);

                    }
                }
            });

            }else{

                $.ajax({
                type: "post",
                url: "loginProceso.php",
                data: {"usuario": rut, "contraseña": pass},
                success: function (response) {
                    var datos = JSON.parse(response);
                    if(datos.estado == "error"){
                        $('#respuesta').append(`<br><div class="alert alert-danger" role="alert">
                            Error de autenticación!
                        </div>`);
                    }else if(datos.estado == "exito"){
                        window.location.href = url;
                    }
                }
            });
            }

          
        });
        
    </script>
</body>
</html>