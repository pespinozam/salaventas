<?php include 'home.php' ?>

<?php startblock('css') ?>
    <style>
    #a-home{
        color: #fff;
    }
    #a-perfil{
        color: rgb(255,151,53);
    }
    #iconPerfil{
        color: rgb(255,151,53);
    }
    </style>
<?php endblock(); ?>

<?php startblock('content') ?>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <?php if(isset($_SESSION['nombre'])): ?>
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="assets/img/user.png">
                <span id="nombrePerfil" class="font-weight-bold"></span><span class="text-black-50"><?php echo $_SESSION['rut']; ?></span><span> </span>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="respuesta"></div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Mi Perfil</h4>
                </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Nombre</label><input type="text" id="nombre" placeholder="Nombre" name="nombre" class="form-control" value=""></div>
                        
                        <div class="col-md-6"><label class="labels">Correo</label><input type="email" id="correo" name="correo" class="form-control" value="" required></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Contraseña actual</label><input type="password" id="passActual" name="passActual" class="form-control" placeholder="ingrese contraseña actual" value=""></div>
                        <div  class="col-md-6"><label class="labels">Nueva contraseña</label><input type="password" id="pass" name="pass" class="form-control" value=""></div>
                        
                    </div>
                    <div class="row mt-3">
                        <!-- <div class="col-md-3"><label class="labels">Telefono</label><input type="text" id="telefono" name="telefono" class="form-control" placeholder="+569" value=""></div> -->
                        <div class="col-md-6"><label class="labels">Telefono</label><input type="text" class="form-control" id="telefono" name="telefono" value="" placeholder="569XXXXXXXX"></div>
                    </div>
                    <div class="mt-5 text-center"><input type="button" id="btnActualizar" style="background-color: rgb(255 151 53); color:white;" value="Actualizar" class="btn mt-3 w-100 p-2" name="perfil-btn"></div>
                   
            </div>
        </div>

    </div>
</div>


<?php endblock(); ?>

<?php startblock('js') ?>
    
<!-- <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script> -->
<script>
    function getDataUser(){
        $.ajax({
        type: "post",
        url: "getDatosPerfil.php",
        data: {"rut": "<?php echo  $_SESSION['rut']; ?>"},
        success: function (response) {
            const user = JSON.parse(response)

            $('#nombre').val(user.nombre);
            $('#nombrePerfil').text(user.nombre);
            $('#correo').val(user.correo);
            // $('#pass').val(user.password);
            $('#telefono').val(user.telefono);
            $('#nickname').val(user.nombre);


        }
        });
    }

    $(document).ready(function () {
    <?php 
        $r = $_SESSION['rut'];
    ?>

    getDataUser();

    $('#btnOcultar').on('click', function(){

    });

    
    $('#btnActualizar').on('click',function(){
       var rut = "<?php echo $r; ?>"
        var passactual = $('#passActual').val();
        var nombre = $('#nombre').val();
        var correo = $('#correo').val();
        var contra = $('#pass').val();
        var tel = $('#telefono').val();
        var ruta = {"rut": rut, "usuario": nombre,"correo": correo, "password": contra, "telefono": tel, "passactual" : passactual}
        
        // var email = document.getElementById('correo').value;
        // var contra = document.getElementById('pass').value;
        // var tel = document.getElementById('telefono').value;
        // var ruta = "rut="+rut+"&nombre="+user+"&correo="+email+"&password="+contra+"&telefono"+tel;
        // alert(ruta);
        
        // if (passactual === ''){
        //     $('.respuesta').append(`<div class="alert alert-info alert-dismissible fade show" role="alert">
        //                     Digitalice contraseña actual para realizar cambios
        //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        //                     </div>`);
        // }else{}
        // $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);
        $.ajax({
                type: "post",
                url: "postperfil.php",
                data: ruta,
                success: function (response) {
                    console.log(response);
                    if(response == true){
                        getDataUser();
                        $('.respuesta').empty();
                        $('.respuesta').append(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Datos usuario actualizados correctamente!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);

                        // window.location.href = 'cerrar.php';
                    }else{
                        $('.respuesta').empty();
                        $('.respuesta').append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error! contraseña actual incorrecta.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);
                    }
                }
            });


    });

});

</script>
<?php endblock() ?>