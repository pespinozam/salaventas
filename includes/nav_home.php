

<nav>
    <div class="navbar">
      <i class='bx bx-menu'></i>
      <div class="logo"><a href="index.php"><img class="logo-name" src="assets/Logo_surmonte_2.png" alt="Surmonte Logo" style="width:300px;"></img></a></div>
      <!-- <div class="logo-proyecto" id="logo-not"><a href="#" ><img class="logo-name" src=">" alt="Surmonte Logo" style="width:300px;"></img></a></div> -->
      <div class="nav-links">
        <div class="sidebar-logo">
        <div class="logo-name">Surmonte</div>
          
          <i class='bx bx-x' ></i>
        </div>
        <ul class="links">
          <li class="d-none">
            <a href="#">HTML & CSS</a>
            <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
            <ul class="htmlCss-sub-menu sub-menu">
              <li><a href="#">Web Design</a></li>
              <li><a href="#">Login Forms</a></li>
              <li><a href="#">Card Design</a></li>
              <li class="more">
                <span><a href="#">More</a>
                <i class='bx bxs-chevron-right arrow more-arrow'></i>
              </span>
                <ul class="more-sub-menu sub-menu">
                  <li><a href="#">Neumorphism</a></li>
                  <li><a href="#">Pre-loader</a></li>
                  <li><a href="#">Glassmorphism</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <input type="hidden" id="url" value="<?php if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
            $url = "https://";   
                else  
            $url = "http://";   
            // Append the host(domain name, ip) to the URL.   
            $url.= $_SERVER['HTTP_HOST'];   

            // Append the requested resource location to the URL   
            $url.= $_SERVER['REQUEST_URI'];     
            echo $url;  ?>"
          >
          <form class="d-none" id="irLogIn" method="POST">

                <input type="hidden" name="url" value="<?php echo $url; ?>">
          </form>
          <li>
              <?php if(isset($_SESSION["rut"])){
                      echo '<a type="button" onClick="btnDesplegar();" href="#">' . $_SESSION["nombre"] . '</a>';
                    }else{
                      echo '<a type="button" style="text-decoration: none; color: white;" onclick="postLogin();">Iniciar Sesión</a>';
                    };
            
              ?>
            
            <?php
              if(isset($_SESSION["rut"])){
                echo '<i id="iconPerfil" class="bx bxs-chevron-down js-arrow arrow"></i>
                <ul class="js-sub-menu sub-menu" style="padding-left: 0px;">
                <li><a id="a-perfil" href="home.php"><i class="fa-solid fa-house" style="margin-right: 10px;"></i>Mi portal</a></li>
                <li><a href="index.php"><i class="fa-solid fa-building" style="margin-right: 10px;"></i>Proyectos</a></li>
                <li><a id="a-perfil" href="https://salaventas.surmonte.cl/perfil.php"><i class="fa-solid fa-user" style="margin-right: 10px;"></i>Mi perfil</a></li>
                <li><a href="../cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket" style="margin-right: 10px;"></i>Cerrar Sesión</a></li>
                </ul>';
              }
            ?>

          </li>
        </ul>
      </div>
      <div class="search-box d-none">
        <i class='bx bx-search'></i>
        <div class="input-box">
          <input type="text" placeholder="Search...">
        </div>
      </div>
    </div>
</nav>
<script type="text/javascript">
  function btnDesplegar(){
    const iconn = document.getElementById("iconPerfil");
    iconn.click();
  }
</script>