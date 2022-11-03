<?php 

$proyecto = trim($_POST["proyecto"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrousel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
 
    <style>
        .imagen_carrusel {
            width: 100% !important;
            height: 450px;
        }
    </style>

</head>
<body>

<?php if($proyecto == "24CRISOSTOMO"){?>
  
<!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">
<!-- Indicators/dots -->
<div class="carousel-indicators">
  <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
  <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
  <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
  <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
  <button type="button" data-bs-target="#demo" data-bs-slide-to="4"></button>
</div>
<!-- The slideshow/carousel -->
<div class="carousel-inner">
  <div class="carousel-item active">
    <img src="carrousel/crisostomo/202_Cocina.jpg"  class="d-block imagen_carrusel" >
    <div class="carousel-caption">
      <h3>24CRISOSTOMO</h3>
      <p><i>Imagenes referenciales</i></p>
    </div>
  </div>
  <div class="carousel-item">
    <img src="carrousel/crisostomo/202_DormPrincipal_Espejo.jpg" alt="Chicago" class="d-block imagen_carrusel" >
    <div class="carousel-caption">
    <h3>24CRISOSTOMO</h3>
    <p><i>Imagenes referenciales</i></p>
    </div> 
  </div>
  <div class="carousel-item">
    <img src="carrousel/crisostomo/202_DormSecundario.jpg" alt="New York" class="d-block imagen_carrusel" >
    <div class="carousel-caption">
    <h3>24CRISOSTOMO</h3>
    <p><i>Imagenes referenciales</i></p>
    </div>  
  </div>
  <div class="carousel-item">
    <img src="carrousel/crisostomo/202_LivingComedor.jpg" alt="New York" class="d-block imagen_carrusel" >
    <div class="carousel-caption">
    <h3>24CRISOSTOMO</h3>
    <p><i>Imagenes referenciales</i></p>
    </div>  
  </div>
  <div class="carousel-item">
    <img src="carrousel/crisostomo/202_Terraza.jpg" alt="New York" class="d-block imagen_carrusel" >
    <div class="carousel-caption">
    <h3>24CRISOSTOMO</h3>
    <p><i>Imagenes referenciales</i></p>
    </div>  
  </div>
</div>
<!-- Left and right controls/icons -->
<button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
  <span class="carousel-control-prev-icon"></span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
  <span class="carousel-control-next-icon"></span>
</button>
</div>
<?php } ?>

<?php if($proyecto == "42LINARES"){?>
<!-- Carousel -->
<div id="demo1" class="carousel slide" data-bs-ride="carousel">
    
    <!-- Indicators/dots -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#demo1" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#demo1" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#demo1" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#demo1" data-bs-slide-to="3"></button>
      <button type="button" data-bs-target="#demo1" data-bs-slide-to="4"></button>
    </div>
    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="carrousel/linares/205_2D_Cocina_comedor2_nuke.jpg"  class="d-block imagen_carrusel" >
        <div class="carousel-caption">
          <h3>42LINARES</h3>
          <p><i>Imagenes referenciales</i></p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="carrousel/linares/205_2D_Cocina2_nuke.jpg" alt="Chicago" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>42LINARES</h3>
        <p><i>Imagenes referenciales</i></p>
        </div> 
      </div>
      <div class="carousel-item">
        <img src="carrousel/linares/205_2D_LivingEvo_nuke.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>42LINARES</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
      <div class="carousel-item">
        <img src="carrousel/linares/205_2D_LivingNormal_nuke.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>42LINARES</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
      <div class="carousel-item">
        <img src="carrousel/linares/205_2D_Terraza_nuke.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>42LINARES</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
    </div>
    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo1" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo1" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
    </div>
    <?php } ?>

<?php if($proyecto == "131WOOD"){?>
<!-- Carousel -->
<div id="demo2" class="carousel slide" data-bs-ride="carousel">
    
    <!-- Indicators/dots -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#demo2" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#demo2" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#demo2" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#demo2" data-bs-slide-to="3"></button>
      <button type="button" data-bs-target="#demo2" data-bs-slide-to="4"></button>
    </div>
    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="carrousel/wood/319_2D_Terraza_pp_.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>131WOOD</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
      <div class="carousel-item">
        <img src="carrousel/wood/319_2D_Dorm_pp_.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>131WOOD</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
      <div class="carousel-item">
        <img src="carrousel/wood/319_2D_Living_pp_.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>131WOOD</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
    </div>
    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo2" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo2" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
    </div>
    <?php } ?>

<?php if($proyecto == "153SANCRISTOBAL"){?>
<!-- Carousel -->
<div id="demo3" class="carousel slide" data-bs-ride="carousel">
    
    <!-- Indicators/dots -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#demo3" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#demo3" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#demo3" data-bs-slide-to="2"></button>
    </div>
    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="carrousel/sancristobal/DeptoA_01_2D_Dorm1_.png"  class="d-block imagen_carrusel" >
        <div class="carousel-caption">
          <h3>153SANCRISTOBAL</h3>
          <p><i>Imagenes referenciales</i></p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="carrousel/sancristobal/DeptoA_04_2D_Bano1_.png" alt="Chicago" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>153SANCRISTOBAL</h3>
        <p><i>Imagenes referenciales</i></p>
        </div> 
      </div>
      <div class="carousel-item">
        <img src="carrousel/sancristobal/DeptoA_05_2D_Cocina_.png" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>153SANCRISTOBAL</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>

    </div>
    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo3" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo3" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
    </div>
    <?php } ?>


<?php if($proyecto == "252MARATHON"){?>
<!-- Carousel -->
<div id="demo4" class="carousel slide" data-bs-ride="carousel">
    
    <!-- Indicators/dots -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#demo4" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#demo4" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#demo4" data-bs-slide-to="2"></button>
    </div>
    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="carrousel/marathon/Depto.202_Cocina.jpg" alt="Chicago" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>252MARATHON</h3>
        <p><i>Imagenes referenciales</i></p>
        </div> 
      </div>
      <div class="carousel-item">
        <img src="carrousel/marathon/Depto.202_Dormitorio_Principal.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>252MARATHON</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
      <div class="carousel-item">
        <img src="carrousel/marathon/Depto.202_Living.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>252MARATHON</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
    </div>
    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo4" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo4" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
    </div>
    <?php } ?>

<?php if($proyecto == "ECV103"){?>
<!-- Carousel -->
<div id="demo5" class="carousel slide" data-bs-ride="carousel">
    
    <!-- Indicators/dots -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#demo5" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#demo5" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#demo5" data-bs-slide-to="2"></button>
    </div>
    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="carrousel/ecv/Depto_120_Comedor-Cocina.jpg" alt="Chicago" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>ECV103</h3>
        <p><i>Imagenes referenciales</i></p>
        </div> 
      </div>
      <div class="carousel-item">
        <img src="carrousel/ecv/Depto_120_Dormitario Principal.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>ECV103</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
      <div class="carousel-item">
        <img src="carrousel/ecv/Depto_120_Living-Comedor.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>ECV103</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
    </div>
    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo5" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo5" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
    </div>
<?php } ?> 

<?php if($proyecto == "TALAVERAS72"){?>
<!-- Carousel -->
<div id="demo6" class="carousel slide" data-bs-ride="carousel">
    
    <!-- Indicators/dots -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#demo6" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#demo6" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#demo6" data-bs-slide-to="2"></button>
    </div>
    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="carrousel/talaveras/ST_INT_101B_Cocina.jpg" alt="Chicago" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>TALAVERAS72</h3>
        <p><i>Imagenes referenciales</i></p>
        </div> 
      </div>
      <div class="carousel-item">
        <img src="carrousel/talaveras/ST_INT_101B_Living Comedor.jpg" alt="New York" class="d-block imagen_carrusel" >
        <div class="carousel-caption">
        <h3>TALAVERAS72</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
      <div class="carousel-item">
        <img src="carrousel/talaveras/ST_INT_Dormitorio_Ppal.jpg" alt="New York" class="d-block imagen_carrusel " >
        <div class="carousel-caption">
        <h3>TALAVERAS72</h3>
        <p><i>Imagenes referenciales</i></p>
        </div>  
      </div>
    </div>
    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo6" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo6" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
    </div>
    <?php } ?> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>