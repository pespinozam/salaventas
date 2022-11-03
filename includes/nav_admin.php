<nav>
    <div class="navbar">
      <i class='bx bx-menu'></i>
      <div class="logo"><a href="index.php"><img class="logo-name" src="assets/Logo_surmonte_2.png" alt="Surmonte Logo" style="width:300px;"></img></a></div>
      <div class="nav-links">
        <div class="sidebar-logo">
        <div class="logo-name">Surmonte</div>
          
          <i class='bx bx-x' ></i>
        </div>
        <ul class="links">
          <li><a id="a-home" href="home.php">HOME</a></li>
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
          <li><a id="a-cotizaciones" href="Vcotizaciones.php">COTIZACIONES</a></li>
          <li><a id="a-reservas" href="Vreserva.php">RESERVAS</a></li>
          <li><a id="a-mis-surmonte" href="misproductsv2.php">MIS SURMONTE</a></li>
          <li>
            <a href="#" id="nickname" style="cursor: default;">
                <?php if(isset($_SESSION['rut'])): ?>
                    <?php echo strtoupper($_SESSION['nombre']); ?>
                <?php endif; ?>
            </a>
            <i id="iconPerfil" class='bx bxs-chevron-down js-arrow arrow'></i>
            <ul class="js-sub-menu sub-menu" style="padding-left: 0px;">
              <li><a id="a-perfil" href="perfil.php"><i class="fa-solid fa-user" style="margin-right: 10px;"></i>Mi perfil</a></li>
              <li><a href="index.php"><i class="fa-solid fa-building" style="margin-right: 10px;"></i>Proyectos</a></li>
              <li><a href="../cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket" style="margin-right: 10px;"></i>Cerrar Sesión</a></li>
            </ul>
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